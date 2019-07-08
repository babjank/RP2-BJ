<?php

// Manualno inicijaliziramo bazu ako već nije.
require_once __DIR__. '/../../model/db.class.php';

$db = DB::getConnection();

$has_tables = false;

try
{
	$st = $db->prepare(
		'SHOW TABLES LIKE :tblname'
	);

	$st->execute( array( 'tblname' => 'PATROLA' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'IZVIDAC' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'VODA' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'AKTIVNOST' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'RADIONICA' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'SUDJELUJE_NA' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'OBAVIJESTI' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;
		
	$st->execute( array( 'tblname' => 'KOMENTAR' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;
		
	$st->execute( array( 'tblname' => 'PROCITANO' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;	
}
catch( PDOException $e ) { exit( "PDO error [show tables]: " . $e->getMessage() ); }


if( $has_tables )
{
	exit( 'Tablice već postoje. Obrišite ih pa probajte ponovno.' );
}

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS PATROLA (' .
		'IME_PATROLE VARCHAR(15) NOT NULL PRIMARY KEY,' .
		'RAZRED ENUM("5","6","7","8"),' .
		'STUPANJ_ZNANJA ENUM("broncani","srebrni","zlatni"),'.
		'ID_RADIONICA INT NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create PATROLA]: " . $e->getMessage() ); }

echo "Napravio tablicu PATROLA.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS IZVIDAC (' .
		'OIB NUMERIC(11) UNSIGNED NOT NULL PRIMARY KEY,' .
		'IME VARCHAR(20),' .
		'PREZIME VARCHAR(20),'.
		'ADRESA VARCHAR(35),' .
		'DATUM_UPISA DATE,' .
		'IME_PATROLE VARCHAR(15),'.
		'EMAIL VARCHAR(50) NOT NULL,' .
		'USERNAME varchar(50) NOT NULL,' .
		'PASSWORD_HASH VARCHAR(255) NOT NULL,' .
		'ULOGIRAN int,' .
		'SLIKA VARCHAR(80))'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create IZVIDAC]: " . $e->getMessage() ); }

echo "Napravio tablicu IZVIDAC.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS VODA (' .
		'OIB NUMERIC(11) UNSIGNED NOT NULL PRIMARY KEY,' .
		'POSTAO_VODA DATE,' .
		'IME_PATROLE VARCHAR(15))'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create VODA]: " . $e->getMessage() ); }

echo "Napravio tablicu VODA.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS RADIONICA (' .
		'ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'DAN CHAR(3),' .
		'SAT TIME)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create RADIONICA]: " . $e->getMessage() ); }

echo "Napravio tablicu RADIONICA.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS AKTIVNOST (' .
		'ID int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'OIB NUMERIC(11) UNSIGNED NOT NULL,' .
		'DATUM_ODRZAVANJA DATE NOT NULL,' .
		'MJESTO VARCHAR(50),' .
		'SIRINA REAL,' .
		'DUZINA REAL,' .
		'OPIS VARCHAR(200),' .
		'CIJENA FLOAT UNSIGNED,' .
		'BROJ_CLANOVA int NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create AKTIVNOST]: " . $e->getMessage() ); }

echo "Napravio tablicu AKTIVNOST.<br />";


try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS SUDJELUJE_NA (' .
		'ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'ID_AKTIVNOST INT NOT NULL,' .
		'OIB NUMERIC(11) UNSIGNED NOT NULL,' .
		'ULOGA VARCHAR(15) NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create SUDJELUJE_NA]: " . $e->getMessage() ); }

echo "Napravio tablicu SUDJELUJE_NA.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS OBAVIJESTI (' .
		'ID NUMERIC(5) UNSIGNED NOT NULL,' .
		'SADRZAJ VARCHAR(500),' .
		'NASLOV VARCHAR(50),' .
		'DATUM DATE,' .
		'OIB NUMERIC(11) UNSIGNED,' .
		'PRIMARY KEY(ID))'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create OBAVIJESTI]: " . $e->getMessage() ); }

echo "Napravio tablicu OBAVIJESTI.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS KOMENTAR (' .
		'ID_KOMENTAR NUMERIC(5) UNSIGNED NOT NULL,' .
		'SADRZAJ VARCHAR(255),' .
		'DATUM DATE,' .
		'OIB NUMERIC(11) UNSIGNED,' .
		'ID_OBAVIJEST NUMERIC(5) UNSIGNED,' .
		'PRIMARY KEY(ID_KOMENTAR))'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create KOMENTAR]: " . $e->getMessage() ); }

echo "Napravio tablicu KOMENTAR.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS PROCITANO (' .
		'OIB1 NUMERIC(11) UNSIGNED,' .
		'OIB2 NUMERIC(11) UNSIGNED,' .
		'BROJ_PROCITANIH NUMERIC(5) UNSIGNED,' .
		'PRIMARY KEY(OIB1, OIB2))'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create KOMENTAR]: " . $e->getMessage() ); }

echo "Napravio tablicu KOMENTAR.<br />";

// Ubaci neke patrole unutra
try
{
	$st = $db->prepare( 'INSERT INTO PATROLA(IME_PATROLE, RAZRED, STUPANJ_ZNANJA, ID_RADIONICA) VALUES (:ime, :razred, :stupanj, :id_radionica )');

	$st->execute( array( 'ime' => 'Anakonda', 'razred' => '8', 'stupanj' => 'srebrni', 'id_radionica' => 3 ) );
	$st->execute( array( 'ime' => 'Nebula', 'razred' => '7', 'stupanj' => 'srebrni', 'id_radionica' => 4 ) );
	$st->execute( array( 'ime' => 'Enelo', 'razred' => '6', 'stupanj' => 'broncani', 'id_radionica' => 1 ) );
	$st->execute( array( 'ime' => 'Servali', 'razred' => '5', 'stupanj' => 'broncani', 'id_radionica' => 2 ) );

}
catch( PDOException $e ) { exit( "PDO error [insert PATROLA]: " . $e->getMessage() ); }

echo "Ubacio u tablicu PATROLA.<br />";

// Ubaci neke izviđače unutra
try
{
	$st = $db->prepare( 'INSERT INTO IZVIDAC(OIB, IME, PREZIME, ADRESA, DATUM_UPISA, IME_PATROLE, EMAIL, USERNAME, PASSWORD_HASH, ULOGIRAN) VALUES (:oib, :ime, :prezime, :adresa, :datum, :patrola, \'a@b.com\', :username, :password, \'0\')' );

	$st->execute( array( 'oib' => 64226562901, 'ime' => 'Fensi', 'prezime' => 'Antolic', 'adresa' => 'Ante Jaksica 18', 'datum' => "2017-10-01", 'patrola' => 'Nebula', 'username' => 'antilopa', 'password' => password_hash( 'nebula', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => 92568529652, 'ime' => 'Mateo', 'prezime' => 'Matosevic', 'adresa' => 'Ante Jaksica 9', 'datum' => "2016-10-01", 'patrola' => 'Nebula', 'username' => 'albatros', 'password' => password_hash( 'nebula', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => 19474757537, 'ime' => 'Leona', 'prezime' => 'Krapovic', 'adresa' => 'Gjalskog 32', 'datum' => "2017-12-01", 'patrola' => 'Nebula', 'username' => 'bizon','password' => password_hash( 'nebula', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => 21385368754, 'ime' => 'Maja', 'prezime' => 'Boric', 'adresa' => 'Gjalskog 37', 'datum' => "2017-11-01", 'patrola' => 'Nebula', 'username' => 'babun', 'password' => password_hash( 'nebula', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => 43654875476, 'ime' => 'Mak', 'prezime' => 'Simur', 'adresa' => 'Kolarova 4', 'datum' => "2017-04-01", 'patrola' => 'Nebula', 'username' => 'boa', 'password' => password_hash( 'nebula', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => 42448434841, 'ime' => 'Tara', 'prezime' => 'Denardis', 'adresa' => 'V. Vidrica 10', 'datum' => "2016-10-01", 'patrola' => 'Enelo', 'username' => 'dabar', 'password' => password_hash( 'enelo', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => 56413295644, 'ime' => 'Sara', 'prezime' => 'Baksa', 'adresa' => 'V. Vidrica 31', 'datum' => "2017-10-01", 'patrola' => 'Enelo', 'username' => 'emu', 'password' => password_hash( 'enelo', PASSWORD_DEFAULT )  ) );
	$st->execute( array( 'oib' => 41451852547, 'ime' => 'Sara', 'prezime' => 'Kokolic', 'adresa' => 'Kolarova 10', 'datum' => "2016-10-01", 'patrola' => 'Enelo', 'username' => 'flamingo', 'password' => password_hash( 'enelo', PASSWORD_DEFAULT )  ) );
	$st->execute( array( 'oib' => 23536562901, 'ime' => 'Davor', 'prezime' => 'Vitez', 'adresa' => 'Kolarova 9', 'datum' => "2017-10-01", 'patrola' => 'Enelo', 'username' => 'galeb', 'password' => password_hash( 'enelo', PASSWORD_DEFAULT )  ) );
	$st->execute( array( 'oib' => 93467529632, 'ime' => 'Lovro', 'prezime' => 'Antolic', 'adresa' => 'Ante Jaksica 18', 'datum' => "2016-10-01", 'patrola' => 'Enelo', 'username' => 'gavran', 'password' => password_hash( 'enelo', PASSWORD_DEFAULT )  ) );
	$st->execute( array( 'oib' => 14564757537, 'ime' => 'Lana', 'prezime' => 'Echert', 'adresa' => 'Ante Jaksica 2', 'datum' => "2018-10-01", 'patrola' => 'Enelo', 'username' => 'hijena', 'password' => password_hash( 'enelo', PASSWORD_DEFAULT )  ) );
	$st->execute( array( 'oib' => 14685368754, 'ime' => 'Lena', 'prezime' => 'Echert', 'adresa' => 'Ante Jaksica 2', 'datum' => "2018-10-01", 'patrola' => 'Enelo', 'username' => 'iverak', 'password' => password_hash( 'enelo', PASSWORD_DEFAULT )  ) );
	$st->execute( array( 'oib' => 27373636358, 'ime' => 'Leonarda', 'prezime' => 'Kokolic', 'adresa' => 'Kolarova 10', 'datum' => "2015-10-01", 'patrola' => 'Servali', 'username' => 'jazavac', 'password' => password_hash( 'servali', PASSWORD_DEFAULT )  ) );
	$st->execute( array( 'oib' => 32876326576, 'ime' => 'Neo', 'prezime' => 'Kokolic', 'adresa' => 'Kolarova 10', 'datum' => "2016-10-01", 'patrola' => 'Servali', 'username' => 'jegulja', 'password' => password_hash( 'servali', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => 84358736621, 'ime' => 'Nia', 'prezime' => 'Lovric', 'adresa' => 'Vranicka 36', 'datum' => "2016-10-01", 'patrola' => 'Servali', 'username' => 'kuna', 'password' => password_hash( 'servali', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => 84358736929, 'ime' => 'Leona', 'prezime' => 'Bogovic', 'adresa' => 'Ilica 229', 'datum' => "2017-10-01", 'patrola' => 'Servali', 'username' => 'kameleon', 'password' => password_hash( 'servali', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => 14347529632, 'ime' => 'Ela', 'prezime' => 'Belina', 'adresa' => 'Gjalskog 74', 'datum' => "2017-10-01", 'patrola' => 'Servali', 'username' => 'klokan', 'password' => password_hash( 'servali', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => 81211322453, 'ime' => 'Domagoj', 'prezime' => 'Benkovic', 'adresa' => 'Kolarova 16', 'datum' => "2014-12-01", 'patrola' => NULL, 'username' => 'lemur', 'password' => password_hash( 'domagojevasifra', PASSWORD_DEFAULT )) );
	$st->execute( array( 'oib' => 11912355361, 'ime' => 'Bjanka', 'prezime' => 'Basic', 'adresa' => 'Remetinecka cesta 7a', 'datum' => "2012-03-01", 'patrola' => NULL, 'username' => 'lasta', 'password' => password_hash( 'bjankinasifra', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => 19124847284, 'ime' => 'Viktoria', 'prezime' => 'Krapovic', 'adresa' => 'V. Vidrica 10', 'datum' => "2010-10-01", 'patrola' => NULL, 'username' => 'losos', 'password' => password_hash( 'viktorijinasifra', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'oib' => 52421322457, 'ime' => 'Nevena', 'prezime' => 'Nikic', 'adresa' => 'Ante Jaksica 11', 'datum' => "2010-05-01", 'patrola' => NULL, 'username' => 'lav', 'password' => password_hash( 'neveninasifra', PASSWORD_DEFAULT ) ) );

}
catch( PDOException $e ) { exit( "PDO error [insert IZVIDAC]: " . $e->getMessage() ); }

echo "Ubacio u tablicu IZVIDAC.<br />";

// zapiši vođe
try
{
	$st = $db->prepare( 'INSERT INTO VODA(OIB, POSTAO_VODA, IME_PATROLE) VALUES (:oib, :datum, :patrola )');

	$st->execute( array( 'oib' => 81211322453, 'datum' => "2016-09-01", 'patrola' => 'Anakonda') );
	$st->execute( array( 'oib' => 11912355361, 'datum' => "2012-09-01", 'patrola' => 'Nebula') );
	$st->execute( array( 'oib' => 19124847284, 'datum' => "2012-09-01", 'patrola' => 'Enelo') );
	$st->execute( array( 'oib' => 52421322457, 'datum' => "2011-09-01", 'patrola' => 'Servali') );

}
catch( PDOException $e ) { exit( "PDO error [insert VODA]: " . $e->getMessage() ); }

echo "Ubacio u tablicu VODA.<br />";

try
{
	$st = $db->prepare( 'INSERT INTO RADIONICA(DAN, SAT) VALUES (:dan, :sat)');

	$st->execute( array( 'dan' => 'PON', 'sat' => "20:00:00") );
	$st->execute( array( 'dan' => 'UTO', 'sat' => "21:00:00") );
	$st->execute( array( 'dan' => 'SRI', 'sat' => "21:00:00") );
	$st->execute( array( 'dan' => 'CET', 'sat' => "20:00:00") );
	$st->execute( array( 'dan' => 'PET', 'sat' => "19:00:00") );
}
catch( PDOException $e ) { exit( "PDO error [insert RADIONICA]: " . $e->getMessage() ); }

echo "Ubacio u tablicu RADIONICA.<br />";

try
{
	$st = $db->prepare( 'INSERT INTO AKTIVNOST(OIB, DATUM_ODRZAVANJA, MJESTO, CIJENA, BROJ_CLANOVA, OPIS, SIRINA, DUZINA) VALUES (:oib, :datum, :mjesto, :cijena, :broj, :opis, :sirina, :duzina)');

	$st->execute( array( 'oib' => 11912355361 , 'datum' => "2019-07-27", 'mjesto' => 'PD Hunjka', 'cijena' => 10, 'broj' => 4, 'opis' => 'Pješački izlet na Sljeme. Ručak u domu, uključeno u cijenu. Puno zabavnih aktivnosti i natjecanje u čvorovima.', 'sirina' => 45.9148989, 'duzina' => 15.9743518) );
	$st->execute( array( 'oib' => 52421322457 , 'datum' => "2019-07-15", 'mjesto' => 'Savudrija', 'cijena' => 1000, 'broj' => 1, 'opis' => 'Ljetno logorovanje. Za detaljne informacije javiti se voditelju.', 'sirina' => 45.4933399, 'duzina' => 13.5019488) );
}
catch( PDOException $e ) { exit( "PDO error [insert AKTIVNOST]: " . $e->getMessage() ); }

echo "Ubacio u tablicu AKTIVNOST.<br />";

try
{
	$st = $db->prepare( 'INSERT INTO SUDJELUJE_NA(ID_AKTIVNOST, OIB, ULOGA) VALUES (:id_aktivnost, :oib, :uloga)' );

	$st->execute( array( 'id_aktivnost' => 1, 'oib' => 11912355361, 'uloga' => 'voda izleta' ) );
	$st->execute( array( 'id_aktivnost' => 1, 'oib' => 64226562901, 'uloga' => 'sudionik' ) );
	$st->execute( array( 'id_aktivnost' => 1, 'oib' => 19474757537, 'uloga' => 'sudionik' ) );
	$st->execute( array( 'id_aktivnost' => 1, 'oib' => 92568529652, 'uloga' => 'sudionik' ) );
	$st->execute( array( 'id_aktivnost' => 2, 'oib' => 52421322457, 'uloga' => 'voda izleta' ) );

}
catch( PDOException $e ) { exit( "PDO error [insert SUDJELUJE_NA]: " . $e->getMessage() ); }

echo "Ubacio u tablicu SUDJELUJE_NA.<br />";

?>
