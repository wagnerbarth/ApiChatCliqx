<?php

class Chat{
 
    // conexão com banco de dados e definição de tabelas
    private $conn;
    private $table_name = "chat";
    private $table_name2 = "users";
 
    // propriedades do objeto
    public $id;
    public $origem;
    public $destino;
    public $mensagem;
    public $data;
 
    // construtor com $db como conexão
    public function __construct($db){
        $this->conn = $db;
    }
    
    // lê mensagem
    function verificarMensagem(){ 
        // query que carrega mensagem
        $query =    "SELECT
                        c.id, c.origem, c.destino, c.mensagem
                    FROM
                        " . $this->table_name . " c
                    WHERE
                        (c.origem=? AND c.destino=? ) OR (c.origem=? AND c.destino=?)
                    ORDER BY 
                        c.id
                    ";

        // prepara query statement
        $stmt = $this->conn->prepare( $query );

        // atualiza o usuário a ser pesquisado 
        $stmt->bindParam(1, $this->origem);
        $stmt->bindParam(2, $this->destino);
        $stmt->bindParam(3, $this->destino);
        $stmt->bindParam(4, $this->origem);


        // executa a query
        $stmt->execute();

        // obtem o registro 
        
        $result = $stmt->fetchAll();

        return $result;



        // define os valores dos atributos
        /* $this->id = $row['id'];
        $this->origem = $row['origem'];
        $this->destino = $row['destino'];
        $this->mensagem = $row['mensagem']; */
       /*  $this->data = $row['data']; */
    }
    
    // cadastrar chat
    /*
        {
            "origem" : "wagner",
            "destino" : "barth",
            "mensagem" : "-------"
        }
     */
    function criarMensagem(){

        // query para inserir o registro
        $query =    "INSERT INTO
                        " . $this->table_name . "
                    SET
                        origem=:origem, 
                        destino=:destino, 
                        mensagem=:mensagem
                    ";
                    
        // prepara a query
        $stmt = $this->conn->prepare($query);

        // limpa caracteres especiais
        $this->origem=htmlspecialchars(strip_tags($this->origem));
        $this->destino=htmlspecialchars(strip_tags($this->destino));
        $this->mensagem=htmlspecialchars(strip_tags($this->mensagem));
        

        // atualiza valores
        $stmt->bindParam(":origem", $this->origem);
        $stmt->bindParam(":destino", $this->destino);
        $stmt->bindParam(":mensagem", $this->mensagem);
  
       /*  echo "criar msg, $this->table_name, $this->origem, $this->destino, $this->mensagem";  
        
        print_r($stmt); */
        // executa query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // verificar lopgin
    function verificarLogin(){ 
        // query que carrega mensagem
        $query =    "SELECT
                       c.nome
                    FROM
                        " . $this->table_name2 . " c
                    WHERE
                        c.email=? AND c.senha=?
                    ";

        // prepara query statement
        $stmt = $this->conn->prepare( $query );

        // atualiza o usuário a ser pesquisado 
        $stmt->bindParam(1, $this->email);
        $stmt->bindParam(2, $this->senha);

        // executa a query
        $stmt->execute();

        // obtem o registro 
        
        $result = $stmt->fetch();

        return $result;



        // define os valores dos atributos
        /* $this->id = $row['id'];
        $this->origem = $row['origem'];
        $this->destino = $row['destino'];
        $this->mensagem = $row['mensagem']; */
       /*  $this->data = $row['data']; */
    }
    
    // receber usuarios
    function receberUsuarios(){ 
        // query que carrega mensagem
        $query =    "SELECT
                        c.nome
                    FROM
                        " . $this->table_name2 . " c
                    ";

        // prepara query statement
        $stmt = $this->conn->prepare( $query );

        // atualiza o usuário a ser pesquisado 
        /* $stmt->bindParam(1, $this->origem);
        $stmt->bindParam(2, $this->destino);
        $stmt->bindParam(3, $this->destino);
        $stmt->bindParam(4, $this->origem);
 */

        // executa a query
        $stmt->execute();

        // obtem o registro 
        
        $result = $stmt->fetchAll();

        return $result;



        // define os valores dos atributos
        /* $this->id = $row['id'];
        $this->origem = $row['origem'];
        $this->destino = $row['destino'];
        $this->mensagem = $row['mensagem']; */
       /*  $this->data = $row['data']; */
    }
}

