<?php
include_once "../../conf/conf.inc.php";

class Database {
    private $conexao;

    public function __construct() {
        $this->conexao = $this->criarConexao();
    }

    public function criarConexao() {
        try {
            $opcoes = array();
            if (PERFIL == "dev") {
                $opcoes = array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                );
            } else {
                $opcoes = array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                    PDO::ATTR_PERSISTENT => true
                );
            }

            $pdo = new PDO(DRIVER . ":host=" . HOST . ";dbname=" . DBNAME . ";charset=" . CHARSET, USER, PASSWORD, $opcoes);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
            return null;
        }
    }

    public function prepararComando($sql, $par) {
        try {
            $comando = $this->conexao->prepare($sql);
            foreach ($par as $chave => $valor) {
                $comando->bindValue($chave, $valor);
            }
            return $comando;
        } catch(PDOException $e) {
            echo 'Erro ao preparar comando SQL: ' . $e->getMessage();
            return null;
        }
    }

    public function executar($sql, $dados = array())
    {
        try {
            $stmt = $this->conexao->prepare($sql);
    
            foreach ($dados as $chave => $valor) {
                $stmt->bindValue(":$chave", $valor);
            }
    
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public function inserir($tabela, $informacoes)
    {
        $colunas = implode(', ', array_keys($informacoes));
        $valores = ':' . implode(', :', array_keys($informacoes));
    
        $sql = "INSERT INTO $tabela ($colunas) VALUES ($valores)";
        $stmt = $this->conexao->prepare($sql);
    
        foreach ($informacoes as $coluna => $valor) {
            $stmt->bindValue(':' . $coluna, $valor);
        }
    
        $stmt->execute();
    }
    
    public function editar($tabela, $dados, $condicao)
    {
        $colunas = [];
        foreach ($dados as $coluna => $valor) {
            if ($coluna !== 'id') {
                $colunas[] = $coluna . ' = :' . $coluna;
            }
        }
    
        $sql = "UPDATE $tabela SET " . implode(', ', $colunas) . " WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
    
        foreach ($dados as $coluna => $valor) {
            $stmt->bindValue(':' . $coluna, $valor);
        }
        $stmt->bindValue(':id', $condicao);
    
        $stmt->execute();
    }
    
    

    public function excluir($tabela, $condicao) {
        $sql = "DELETE FROM `$tabela` WHERE (`id` = '$condicao');";
        return $this->executar($sql, array());
    }
}
?>
