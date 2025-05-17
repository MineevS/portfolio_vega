<?php
	$connectionParams = array(
		'driver' 	=> 'pdo_pgsql',

		'host' 		=> 'localhost',
		'port' 		=> 	5432,

		'dbname' 	=> 'portfolioDB',

		'user' 		=> 'postgres',
		'password' 	=> 'postgres'
	);

	use Doctrine\DBAL\DriverManager;
    
    $config = new \Doctrine\DBAL\Configuration();

    $conn = DriverManager::getConnection($connectionParams, $config);
	
    // $queryBuilder = $conn->createQueryBuilder();

    // $queryBuilder = $queryBuilder->select('version()');
	/// For Debug:
    // $version = $queryBuilder->executeQuery()->fetchOne(); // execute()->fetchColumn(0)
    // echo $version . "\n\r";
?>