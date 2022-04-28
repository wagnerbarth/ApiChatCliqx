<?php

/* database script
 --
-- Estrutura da tabela `chats`
--

create table chat (
id int PRIMARY KEY AUTO_INCREMENT,
origem VARCHAR(32) NOT NULL,
destino VARCHAR(32) NOT NULL,
mensagem VARCHAR(255)
);

insert into chat (origem, destino, mensagem) values
('joao','leo', 'oi'), 
('mary','leo', 'e ai'),
('leo','oliver', 'oi e ai'),
('oliver','leo', 'blz'),
('leo','joao', 'ok'),
('leo','joao', 'vai la');

select origem, destino, mensagem from chat where (origem = 'joao' and destino = "leo") or (origem = 'leo' and destino = "joao") ORDER BY id;

 */

class Database{
 
    // especifica as credencias de conexão
    private $host = "localhost";
    private $db_name = "chat";
    private $username = "barth";
    private $password = "123456";
    public $conn;
 
    // define a conexão com o banco de dados
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
