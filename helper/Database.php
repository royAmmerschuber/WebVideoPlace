<?php
class Database{

    private static $instance = null;
    private $config;
    private $pdo;

    private function __construct(){
        $this->config = parse_ini_file(__DIR__.'/../config/database.ini');
        try{
            $this->pdo = new PDO($this->config['engine'].':host='.$this->config['host'].';dbname='.$this->config['database'],
                $this->config['username'],$this->config['password']);
        }catch (Exception $e){
//            echo $e->getMessage();
            $this->pdo=new PDO($this->config['engine'].
                ':host='.$this->config['host'],
                $this->config['username'],
                $this->config['password']
            );
            $this->pdo->exec("Create Database ".$this->config['database'].";USE ".$this->config['database']);
            $this->seed();
        }


    }

    public static function instance():Database{
        if(Database::$instance == null){
            Database::$instance = new Database();
        }
        return Database::$instance;
    }

    public function connection():PDO{
        return $this->pdo;
    }

    private function seed(){
        echo "database seeding";
        $this->pdo->exec(
        "Create Table User(
            id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
            name VARCHAR(64) NOT NULL ,
            password VARCHAR(256) NOT NULL,
            email VARCHAR(64) NOT NULL )
            ");
        $this->pdo->exec(
            "Create Table Video(
              id INT PRIMARY KEY AUTO_INCREMENT NOT NULL ,
              name VARCHAR(128) NOT NULL ,
              description VARCHAR(1024) NOT NULL ,
              video VARCHAR(64) NOT NULL ,
              thumbnail VARCHAR(64) NOT NULL,
              userFK INT NOT NULL ,
              views INT NOT NULL 
            )"
        );
        $this->pdo->exec(
            "Create Table Comment(
              id int not null PRIMARY KEY AUTO_INCREMENT,
              text VARCHAR(1024) NOT NULL, 
              userFK INT NOT NULL ,
              videoFK INT NOT NULL
              )"
        );
        $this->pdo->exec(
            "Create Table LikeDislike(
              isPositive BOOLEAN NOT NULL ,
              userFK INT NOT NULL ,
              videoFK INT NOT NULL,
              PRIMARY KEY (userFK,videoFK)
            )"
        );
    }

}
?>
