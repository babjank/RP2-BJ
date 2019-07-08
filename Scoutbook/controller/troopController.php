<?php

require_once "model/service.class.php";

class TroopController
{
	public function index()
	{
		$tus = new Service();

		require_once "view/troop_index.php";
	}

	public function activities()
	{
		// Funkcija pomoću koje dohvaćamo sve aktivnosti, koje prikazujemo u sklopu odjeljka "Aktivnosti"
		$tus = new Service();

		$aktivnostList = $tus->getAllActivities();
		$izvidacList = [];

		foreach ($aktivnostList as $aktivnost) {
			$id = $aktivnost->id_izvidac;
			$izvidac = $tus->getUserById($id);
			$izvidacList[$id] = $izvidac->username;
		}

		$byUser = false;
		require_once "view/activity_index.php";
	}

	public function myactivities()
	{
		// Funkcija pomoću koje dohvaćamo aktivnosti trenutno ulogiranog korisnika, a prikazujemo ih u sklopu odjeljka "Moje aktivnosti"
		$tus = new Service();

		$aktivnostList = $tus->getAcitivtiesByMemberId($_SESSION["id"]);
		$izvidacList = [];

		foreach ($aktivnostList as $aktivnost) {
			$id = $aktivnost->id_izvidac;
			$izvidac = $tus->getUserById($id);
			$izvidacList[$id] = $izvidac->username;
		}

		$byUser = true;
		require_once "view/activity_index.php";
	}

	public function newactivity()
	{
		require_once "view/activity_new.php";
	}

	public function newactivityinput()
	{
		// Funkcija pomoću koje pokrećemo ubacivanje podataka o novoj aktivnosti u bazu podataka ako su svi potrebni podaci uneseni u formu za unos nove aktivnosti
		$tus = new Service();

		$errorMsg = "NOT_SET";

		if (isset($_POST["mjesto"]) && isset($_POST["datum"]) && isset($_POST["cijena"]) &&
		(strcmp($_POST["mjesto"], "") !== 0) && (strcmp($_POST["datum"], "") !== 0)) {
			$retVal = $tus->insertActivity($_SESSION["id"], $_POST["mjesto"], $_POST["datum"], $_POST["cijena"], $_POST["abstract"], $_POST["sirina"], $_POST["duzina"]);
			$errorMsg = $retVal[0]; // Poruka koja se ispisuje ako je nešto pošlo po zlu prilikom ubacivanja podataka u bazu
			$id_aktivnost = $retVal[1]; // ID novonastale aktivnosti, potreban kako bismo omogućili vođi da vidi stranicu s opisom aktivnosti koju je stvorio
		}

		require_once "view/activity_newinput.php";
	}

	public function newmember()
	{
		require_once "view/addnewmember.php";
	}

	public function newmemberinput()
	{
		// Funkcija pomoću koje pokrećemo ubacivanje podataka o novom izviđaču (korisniku aplikacije) u bazu podataka ako su svi potrebni podaci uneseni u formu za unos novog korisnika
		$tus = new Service();

		$errorMsg = "NOT_SET";

		if (isset($_POST["oib"]) && isset($_POST["ime"]) && isset($_POST["prezime"]) && isset($_POST["adresa"])
		&& isset($_POST["email"]) && (strcmp($_POST["oib"], "") !== 0) && (strcmp($_POST["ime"], "") !== 0)
		&& (strcmp($_POST["prezime"], "") !== 0) && (strcmp($_POST["adresa"], "") !== 0)
		&& (strcmp($_POST["email"], "") !== 0)) {
			$patrola = $tus->getLeadersPatrol($_SESSION["id"]);
			$errorMsg = $tus->insertMember($_POST["oib"], $_POST["ime"], $_POST["prezime"], $_POST["adresa"],
										$_POST["email"], $patrola);
		}

		require_once "view/addnewmember.php";
	}

	public function showmine()
	{
		// Funkcija koju koristimo kako bismo prikazali stranicu s informacijama o nekoj aktivnosti koja je aktivnost trenutno ulogiranog člana
		$tus = new Service();

		$activityId = $_GET["id_aktivnost"];
		$aktivnost = $tus->getActivityById($activityId);
		$voda = $tus->getUserById($aktivnost->id_izvidac)->username;

		$_SESSION["id_aktivnost"] = $_GET["id_aktivnost"];

		$mine = false;
		if( $voda == $_SESSION["username"]) {
			$mine = true;
			$memberList = $tus->getMembersByActivityId($activityId);

			foreach ($memberList as $member) {
				$id = $member->id_izvidac;
				$user = $tus->getUserById($id);
				$izvidacList[$id] = $user->username;
			}
		}

		require_once "view/singleactivity_index.php";
	}

	public function show()
	{
		// Funkcija koju koristimo kako bismo prikazali stranicu s informacijama o aktivnosti dostupnoj preko popisa svih aktivnosti u odjeljku "Aktivnosti"
		$tus = new Service();

		$activityId = $_GET["id_aktivnost"];
		$aktivnost = $tus->getActivityById($activityId);
		$voda = $tus->getUserById($aktivnost->id_izvidac)->username;

		$memberList = $tus->getMembersByActivityId($activityId);
		$isaMember = false;

		foreach ($memberList as $member) {
			if (strcmp($member->id_izvidac, $_SESSION["id"]) === 0)
				$isaMember = true;
		}

		$_SESSION["id_aktivnost"] = $_GET["id_aktivnost"];

		require_once "view/activity_show.php";
	}

	public function apply()
	{
		// Funkcija pomoću koje obavljamo prijavljivanje trenutno ulogiranog korisnika na neku aktivnost
		$tus = new Service();

		$activityId = $_GET["id_aktivnost"];
		$aktivnost = $tus->getActivityById($activityId);

		$memberList = $tus->getMembersByActivityId($activityId);
		$isaMember = false;

		foreach ($memberList as $member) {
			if (strcmp($member->id_izvidac, $_SESSION["id"]) === 0)
				$isaMember = true; 
		// provjeravamo je li trenutno ulogiran član već prijavljen na danu aktivnost (nemoguće je dvaput se prijaviti na istu aktivnost)
		}

		if ($isaMember)
			$errorMsg = "Već ste se prijavili za aktivnost.";
		else
			$errorMsg = $tus->insertMemberOfActivity($activityId, $_SESSION["id"]);

		require_once "view/activity_apply.php";
	}

	public function patrol()
	{
		// Funkcija pomoću koje dohvaćamo sve članove odgovarajuće patrole, koje prikazujemo u sklopu odjeljka "Patrola"
		$tus = new Service();
		
		/* Ako popisu članova patrole pristupamo preko grafičkog prikaza odreda u odjeljku "Odred",
		tada šaljemo i vrijednost ime_patrole.
		Inače, patrola čije članove želimo vidjeti ona je patrola čiji je član trenutno ulogirani korisnik (ili vođa, ako se radi o vođi)
		*/
		if (isset($_GET["ime_patrole"])) 
			$patrola = $_GET["ime_patrole"];
		else if (!$_SESSION["voda"]) 
			$patrola = $tus->getUserById($_SESSION["id"])->ime_patrole;
		else
			$patrola = $tus->getLeadersPatrol($_SESSION["id"]);
		$izvidaci = $tus->getUsersByPatrol($patrola);

		require_once "view/patrol_index.php";
	}

	public function news()
	{
		/* Prilikom ulaska u aplikaciju klikom na scoutbook.php, ulogirani se korisnik preusmjerava 
		na odjeljak "Obavijesti". To je tada trenutno aktivni odjeljak, što je potrebno eksplicitno naznačiti 
		(jer se inače trenutno aktivni odjeljak određuje na temelju posljednjeg klika na neki od elemenata liste
		unutar headera)
		*/
		echo "<script>sessionStorage.setItem('aktivan', 'obavijesti')</script>";

		$voda = $_SESSION["voda"];

		require_once "view/news_index.php";
	}

	public function newNotification()
	{
		// Funkcija koja omogućava unos nove obavijesti (koju je u odgovarajuću formu upisao trenutno ulogirani vođa) u bazu podataka
		$sadrzaj = $_POST["objava"];
		$naslov = $_POST["naslov"];
		$datum = date("Y-m-d"); // Datum objave je aktualni datum

		$tus = new Service();
		$tus->insertNews($sadrzaj, $naslov, $datum, $_SESSION["id"]);

		// Nakon uspješnog unosa nove obavijesti, korisnik se ponovno preusmjerava na odjeljak "Novosti"
		header("Location: scoutbook.php?rt=troop/news");
		exit();
	}

	public function objaviKomentar()
	{
		// Funkcija koja omogućava unos novog komentara neke obavijesti u bazu podataka
		$id_obavijest = $_GET["id_obavijest"];
		$sadrzaj = $_POST["komArea" . $id_obavijest];

		$tus = new Service();

		$tus->addComment($sadrzaj, date("Y-m-d"), $_SESSION["id"], $id_obavijest);

		// Nakon uspješnog unosa novog komentara, korisnik se ponovno preusmjerava na odjeljak "Novosti"
		header("Location: scoutbook.php?rt=troop/news");
		exit();
	}
};

?>
