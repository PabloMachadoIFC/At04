<?php
require_once('database.class.php');

class Triangulo extends Database {

    private $id;
    private $lado1;
    private $lado2;
    private $lado3;
    private $cor;
    private $tipo;

    public function __construct($pid, $plado1, $plado2, $plado3, $pcor, $ptipo = '') {
        $this->setId($pid);
        $this->setLado1($plado1);
        $this->setLado2($plado2);
        $this->setLado3($plado3);
        $this->setCor($pcor);
        $this->setTipo($ptipo);
    }
    public function excluir($tabela, $id)
    {
        $db = new Database();
        $db->excluir($tabela, $id);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLado1() {
        return $this->lado1;
    }

    public function setLado1($lado1) {
        if ($lado1 > 0) {
            $this->lado1 = $lado1;
        } else {
            throw new Exception("Lado do triângulo inválido. Informe um valor maior que 0");
        }
    }
    public function editar($tabela, $dados, $condicao)
    {
        $db = new Database();
        $db->editar($tabela, $dados, $condicao);
    }
    public function buscarTodos()
    {
        $db = new Database();
        $conexao = $db->criarConexao();

        $sql = "SELECT * FROM triangulo";
        $stmt = $conexao->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listar($tabela)
    {
        $resultados = $this->buscarTodos();
        $triangulos = array();

        if ($resultados !== null) {
            foreach ($resultados as $resultado) {
                $triangulo = new Triangulo($resultado['id'], $resultado['lado1'], $resultado['lado2'], $resultado['lado3'], $resultado['cor'], $resultado['tipo']);
                $triangulos[] = $triangulo;
            }
        }

        return $triangulos;
    }

    public function getLado2() {
        return $this->lado2;
    }

    public function setLado2($lado2) {
        if ($lado2 > 0) {
            $this->lado2 = $lado2;
        } else {
            throw new Exception("Lado do triângulo inválido. Informe um valor maior que 0");
        }
    }

    public function getLado3() {
        return $this->lado3;
    }

    public function setLado3($lado3) {
        if ($lado3 > 0) {
            $this->lado3 = $lado3;
        } else {
            throw new Exception("Lado do triângulo inválido. Informe um valor maior que 0");
        }
    }

    public function getCor() {
        return $this->cor;
    }

    public function setCor($cor) {
        if ($cor != '') {
            $this->cor = $cor;
        } else {
            throw new Exception("Cor do triângulo inválida. Informe uma cor");
        }
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
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

        $sql = "SELECT * FROM triangulo WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $triangulo = new Triangulo(
                $row['id'],
                $row['lado1'],
                $row['lado2'],
                $row['lado3'],
                $row['cor'],
                $row['tipo']
            );

            return $triangulo;
        } else {
            return null;
        }
    }

    public function calcularPerimetro() {
        return $this->lado1 + $this->lado2 + $this->lado3;
    }

    public function calcularArea() {
        $semiperimetro = $this->calcularPerimetro() / 2;
        $area = sqrt($semiperimetro * ($semiperimetro - $this->lado1) * ($semiperimetro - $this->lado2) * ($semiperimetro - $this->lado3));
        return $area;
    }

    public function desenhar() {
        $tipo = $this->getTipo();

        switch ($tipo) {
            case 'Retângulo':
                $maiorLado = max($this->lado1, $this->lado2, $this->lado3);
                $hipotenusa = sqrt(pow($this->lado1, 2) + pow($this->lado2, 2));
                $altura = $hipotenusa;
                $base = min($this->lado1, $this->lado2, $this->lado3);

                $desenho = "<div class='desenho'
                                style='
                                    width: 0;
                                    height: 0;
                                    border-left: {$base}px solid transparent;
                                    border-right: {$altura}px solid transparent;
                                    border-bottom: {$maiorLado}px solid {$this->cor};
                                    border-top: 0;
                                '>
                            </div>";
                break;

            case 'Equilátero':
                $lado = $this->lado1;
                $altura = ($lado * sqrt(3)) / 2;
                $ladoA = $lado/2;
                $desenho = "<div class='desenho'
                                style='
                                    width: 0;
                                    height: 0;
                                    border-left: {$ladoA}px solid transparent;
                                    border-right: {$ladoA}px solid transparent;
                                    border-bottom: {$altura}px solid {$this->cor};
                                    border-top: 0;
                                '>
                            </div>";
                break;

            case 'Isósceles':
                $maiorLado = max($this->lado1, $this->lado2, $this->lado3);
                $base = min($this->lado1, $this->lado2, $this->lado3);
                $altura = sqrt(pow($maiorLado, 2) - pow($base, 2));
                $desenho = "<div class='desenho'
                                style='
                                    width: 0;
                                    height: 0;
                                    border-left: {$base}px solid transparent;
                                    border-right: {$base}px solid transparent;
                                    border-bottom: {$altura}px solid {$this->cor};
                                    border-top: 0;
                                '>
                            </div>";
                break;

            case 'Escaleno':
                $perimetro = $this->calcularPerimetro();
                $p = $perimetro / 2;
                $area = sqrt($p * ($p - $this->lado1) * ($p - $this->lado2) * ($p - $this->lado3));

                $desenho = "<div class='desenho'
                                style='
                                    width: 0;
                                    height: 0;
                                    border-left: {$this->lado1}px solid transparent;
                                    border-right: {$this->lado2}px solid transparent;
                                    border-bottom: {$this->lado3}px solid {$this->cor};
                                    border-top: 0;
                                '>
                            </div>";
                break;

            default:
                $desenho = "<div class='desenho'>
                                Tipo de triângulo inválido.
                            </div>";
                break;
        }

        return $desenho;
    }

    public function salvar() {
        $dados = array(
            'id' => $this->id,
            'lado1' => $this->lado1,
            'lado2' => $this->lado2,
            'lado3' => $this->lado3,
            'cor' => $this->cor,
            'tipo' => $this->tipo
        );

        $this->inserir('triangulo', $dados);
    }
}
