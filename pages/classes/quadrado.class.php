<?php
    require_once('database.class.php');
    class Quadrado extends Database {

        /*
        * Atributos da Classe
        */

        private $id; // int
        private $lado; // int
        private $cor; // string
        private $tamanho; // string

        /*
        * Construtor = definir o estado inicial do objeto
        */

        public function __construct($pid, $plado, $pcor, $ptamanho) {
            $this->setId($pid);
            $this->setLado($plado);
            $this->setCor($pcor);
            $this->setTamanho($ptamanho);
        }

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

    
        public function getLado() {
            return $this->lado;
        }


        public function setLado($lado) {
            if ($lado > 0) {
                $this->lado = $lado;
            } else {
                throw new Exception("Lado do quadrado inválido. Informe um valor maior que 0");
            }
        }

        public function getCor() {
            return $this->cor;
        }


        public function setCor($cor) {
            if ($cor != '') {
                $this->cor = $cor;
            } else {
                throw new Exception("Cor do quadrado inválido. Informe uma Cor");
            }
        }

        public function getTamanho() {
            return $this->tamanho;
        }

     
        public function setTamanho($tamanho) {
            if($tamanho != ''){
                $this->tamanho = $tamanho;
            } else{
                throw new Exception('Unidade de medida inválida. Selecione uma unidade correta');
            }
        }

        public function inserir($tabela, $dados)
        {
            $db = new Database();
            $db->inserir($tabela, $dados);
        }
        public function buscarPorId($id)
    {
        $db = new Database();
        $conexao = $db->criarConexao();
    
        $sql = "SELECT * FROM quadrado WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            $quadrado = new Quadrado(
                $row['id'],
                $row['lado'],
                $row['cor'],
                $row['tamanho']
            );
    
            return $quadrado;
        }
    
        return null;
    }
    
        
    public function editar($tabela, $dados, $condicao)
    {
        $db = new Database();
        $db->editar($tabela, $dados, $condicao);
    }
    
        public function excluir($tabela, $id)
        {
            $db = new Database();
            $db->excluir($tabela, $id);
        }
    
        public function buscarTodos()
        {
            $db = new Database();
            $conexao = $db->criarConexao();
    
            $sql = "SELECT * FROM quadrado";
            $stmt = $conexao->query($sql);
    
            return $stmt;
        }
    

        public function desenhar($lado,$tamanho,$cor){
            $desenho = "<div class='desenho'
                            style='
                                width:{$lado}{$tamanho};
                                height:{$lado}{$tamanho};
                                background-color:{$cor};
                            '>
                        </div>";
            return $desenho;
        }

        public function calcular()
{
    $area = $this->lado * $this->lado;
    $perimetro = 4 * $this->lado;

    return array('area' => $area, 'perimetro' => $perimetro);
}
    }

?>