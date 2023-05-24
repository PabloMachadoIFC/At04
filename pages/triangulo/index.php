<?php
    require_once('../../conf/conf.inc.php');
    require_once('../classes/triangulo.class.php');

    $acao = "";
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
            break;
        case 'POST':
            $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
            break;
    }

    $dados = array();
    switch ($acao) {
        case 'excluir':
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            $lado1 = isset($_POST['lado1']) ? $_POST['lado1'] : '2';
            $lado2 = isset($_POST['lado2']) ? $_POST['lado2'] : '2';
            $lado3 = isset($_POST['lado3']) ? $_POST['lado3'] : '2';
            $cor = isset($_POST['cor']) ? $_POST['cor'] : '#000000';
            $triangulo = new Triangulo($id, $lado1, $lado2, $lado3, $cor);
            $triangulo->excluir('triangulo', $id);
            break;
        case 'salvar':
            {
                $id = isset($_POST['id']) ? $_POST['id'] : 0;
                if ($id == 0)
                {
                    // echo "SALVAR";
                    $id = isset($_GET['id']) ? $_GET['id'] : 0;
                    $lado1 = isset($_POST['lado1']) ? $_POST['lado1'] : '2';
                    $lado2 = isset($_POST['lado2']) ? $_POST['lado2'] : '2';
                    $lado3 = isset($_POST['lado3']) ? $_POST['lado3'] : '2';
                    $cor = isset($_POST['cor']) ? $_POST['cor'] : '#000000';
                    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';

                    $informacoes = array(
                        'id' => $id,
                        'lado1' => $lado1,
                        'lado2' => $lado2,
                        'lado3' => $lado3,
                        'cor' => $cor,
                        'tipo' => $tipo
                    );
                    $triangulo = new Triangulo($id, $lado1, $lado2, $lado3, $cor, $tipo);
                    $triangulo->inserir('triangulo', $informacoes);
                    break;
                }
                elseif ($id != 0){
                    //  var_dump($_POST);
                    //  echo "EDITAR";
                    $lado1 = isset($_POST['lado1']) ? $_POST['lado1'] : '2';
                    $lado2 = isset($_POST['lado2']) ? $_POST['lado2'] : '2';
                    $lado3 = isset($_POST['lado3']) ? $_POST['lado3'] : '2';
                    $cor = isset($_POST['cor']) ? $_POST['cor'] : '#000000';
                    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';

                    $informacoes = array(
                        'id' => $id,
                        'lado1' => $lado1,
                        'lado2' => $lado2,
                        'lado3' => $lado3,
                        'cor' => $cor,
                        'tipo' => $tipo
                    );
                    $triangulo = new Triangulo($id, $lado1, $lado2, $lado3, $cor, $tipo);
                    $triangulo->editar('triangulo', $informacoes, $id);
                    // var_dump($triangulo);
                }
                break;
            }
            
        case 'editar':
        {
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            $lado1 = isset($_POST['lado1']) ? $_POST['lado1'] : '2';
            $lado2 = isset($_POST['lado2']) ? $_POST['lado2'] : '2';
            $lado3 = isset($_POST['lado3']) ? $_POST['lado3'] : '2';
            $cor = isset($_POST['cor']) ? $_POST['cor'] : '#000000';
            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';

            $informacoes = array(
                'id' => $id,
                'lado1' => $lado1,
                'lado2' => $lado2,
                'lado3' => $lado3,
                'cor' => $cor,
                'tipo' => $tipo
            );
            $triangulo = new Triangulo($id, $lado1, $lado2, $lado3, $cor, $tipo);
            $dados = $triangulo->buscarPorId($id);
            break;
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro de Triângulo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <style>
            .desenho{
                border: 1px solid black;
                display: inline-block;
            }
        </style>
    </head>
    <body>
        <a href="../../index.php">Voltar</a>
        <center><h1>CRUD Triângulo</h1></center>
        <div class="row">
            <div class="col-12">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-3">
                            <label for="id">ID</label>
                            <input type="text" name="id" id="id"  class="form-control" readonly value="<?= ($acao == 'editar' && $dados !== null && null !== $dados->getId()) ? $dados->getId() : '0'; ?>">
                        </div>
                        <div class="col-3">
                            <label for="lado1">Lado 1</label>
                            <input type="text" name="lado1" id="lado1" class="form-control" value="<?= ($acao == 'editar' && null !== $dados->getLado1()) ? $dados->getLado1() : ''; ?>">
                        </div>
                        <div class="col-3">
                            <label for="lado2">Lado 2</label>
                            <input type="text" name="lado2" id="lado2" class="form-control" value="<?= ($acao == 'editar' && null !== $dados->getLado2()) ? $dados->getLado2() : ''; ?>">
                        </div>
                        <div class="col-3">
                            <label for="lado3">Lado 3</label>
                            <input type="text" name="lado3" id="lado3" class="form-control" value="<?= ($acao == 'editar' && null !== $dados->getLado3()) ? $dados->getLado3() : ''; ?>">
                        </div>
                        <div class="col-3">
                            <label for="cor">Cor</label>
                            <input type="color" name="cor" id="cor" class="form-control" value="<?= ($acao == 'editar' && null !== $dados->getCor()) ? $dados->getCor() : ''; ?>"> 
                        </div>
                        <div class="col-3">
                            <label for="tipo">Tipo de Triângulo</label>
                            <select name="tipo" id="tipo" class="form-control">
                                <option value="">Selecione</option>
                                <option value="Retângulo" <?= ($acao == 'editar' && $dados !== null && $dados->getTipo() == 'Retângulo') ? 'selected' : ''; ?>>Triângulo Retângulo</option>
                                <option value="Equilátero" <?= ($acao == 'editar' && $dados !== null && $dados->getTipo() == 'Equilátero') ? 'selected' : ''; ?>>Triângulo Equilátero</option>
                                <option value="Isósceles" <?= ($acao == 'editar' && $dados !== null && $dados->getTipo() == 'Isósceles') ? 'selected' : ''; ?>>Triângulo Isósceles</option>
                                <option value="Escaleno" <?= ($acao == 'editar' && $dados !== null && $dados->getTipo() == 'Escaleno') ? 'selected' : ''; ?>>Triângulo Escaleno</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <center>
                                <button type="submit" class="btn btn-primary" name="acao" value="salvar"><?= ($acao == 'editar') ? 'Editar Triângulo' : 'Criar Triângulo'; ?></button>
                            </center>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Lado 1</th>
                            <th>Lado 2</th>
                            <th>Lado 3</th>
                            <th>Cor</th>
                            <th>Tipo</th>
                            <th>Desenho</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $triangulo = new Triangulo('2', '3', '4', 'f', '2', 's');
                        $resultados = $triangulo->listar('triangulo');
                        if ($resultados !== null) {
                            foreach ($resultados as $triangulo) {
                        ?>
                                <tr>
                                    <td><?= $triangulo->getId(); ?></td>
                                    <td><?= $triangulo->getLado1(); ?></td>
                                    <td><?= $triangulo->getLado2(); ?></td>
                                    <td><?= $triangulo->getLado3(); ?></td>
                                    <td><?= $triangulo->getCor(); ?></td>
                                    <td><?= $triangulo->getTipo(); ?></td>
                                    <td><?= $triangulo->desenhar($triangulo->getLado1(), $triangulo->getLado2(), $triangulo->getLado3(), $triangulo->getCor()); ?></td>
                                    <td>
                                        <a href="index.php?acao=editar&id=<?= $triangulo->getId(); ?>">Editar</a>
                                        <a href="index.php?acao=excluir&id=<?= $triangulo->getId(); ?>">Excluir</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </body>
</html>
