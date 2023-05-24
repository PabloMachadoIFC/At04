<?php
    require_once('../../conf/conf.inc.php');
    require_once('../classes/quadrado.class.php');

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
            $lado = isset($_POST['lado']) ? $_POST['lado'] : '2';
            $cor = isset($_POST['cor']) ? $_POST['cor'] : '#000000';
            $tamanho = isset($_POST['tamanho']) ? $_POST['tamanho'] : '2';
            $quadrado = new Quadrado($id, $lado, $cor, $tamanho);
            $quadrado->excluir('quadrado', $id);
            break;
        case 'salvar':
            {
                
                $id = isset($_POST['id']) ? $_POST['id'] : 0;
                if ($id == 0)
                {
                    // echo "SALVAR";
                    $id = isset($_GET['id']) ? $_GET['id'] : 0;
                    $lado = isset($_POST['lado']) ? $_POST['lado'] : '2';
                    $cor = isset($_POST['cor']) ? $_POST['cor'] : '#000000';
                    $tamanho = isset($_POST['tamanho']) ? $_POST['tamanho'] : '2';
            
                    $informacoes = array(
                        'id' => $id,
                        'lado' => $lado,
                        'cor' => $cor,
                        'tamanho' => $tamanho
                    );
                    $quadrado = new Quadrado($id, $lado, $cor, $tamanho);
                    $quadrado->inserir('quadrado', $informacoes);
                    break;
                }
                elseif ($id != 0){
                    //  var_dump($_POST);
                    //  echo "EDITAR";
                    $lado = isset($_POST['lado']) ? $_POST['lado'] : '2';
                    $cor = isset($_POST['cor']) ? $_POST['cor'] : '#000000';
                    $tamanho = isset($_POST['tamanho']) ? $_POST['tamanho'] : '2';
        
                    $informacoes = array(
                        'id' => $id,
                        'lado' => $lado,
                        'cor' => $cor,
                        'tamanho' => $tamanho
                    );
                    $quadrado = new Quadrado($id, $lado, $cor, $tamanho);
                    $quadrado->editar('quadrado', $informacoes, $id);
                    // var_dump($quadrado);
                }
                break;
            }
            
        case 'editar':
        {
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            $lado = isset($_POST['lado']) ? $_POST['lado'] : '2';
            $cor = isset($_POST['cor']) ? $_POST['cor'] : 'f';
            $tamanho = isset($_POST['tamanho']) ? $_POST['tamanho'] : '2';

            $informacoes = array(
                'id' => $id,
                'lado' => $lado,
                'cor' => $cor,
                'tamanho' => $tamanho
            );
            $quadrado = new Quadrado($id, $lado, $cor, $tamanho);
            $dados = $quadrado->buscarPorId($id);
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
        <title>Cadastro de Quadrados</title>
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
        <center><h1>CRUD Quadrado</h1></center>
        <div class="row">
            <div class="col-12">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-3">
                            <label for="id">ID</label>
                            <input type="text" name="id" id="id"  class="form-control" readonly value="<?= ($acao == 'editar' && $dados !== null && null !== $dados->getId()) ? $dados->getId() : '0'; ?>">
                        </div>
                        <div class="col-3">
                            <label for="lado">Lado</label>
                            <input type="text" name="lado" id="lado" class="form-control" value="<?= ($acao == 'editar' && null !== $dados->getLado()) ? $dados->getLado() : ''; ?>">
                        </div>
                        <div class="col-3">
                            <label for="cor">Cor</label>
                            <input type="color" name="cor" id="cor" class="form-control" value="<?= ($acao == 'editar' && null !== $dados->getCor()) ? $dados->getCor() : ''; ?>"> 
                        </div>
                        <div class="col-3">
                            <label for="tamanho">Tamanho</label>
                            <select class="form-control" name="tamanho" id="tamanho">
                                <option value="cm">CM - Centímetro</option>
                                <option value="px">PX - Píxel</option>
                                <option value="%">% - Porcentagem</option>
                                <option value="vh">VH - Viewport Height</option>
                                <option value="vw">VW - Viewport Width</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <center>
                                <button type="submit" class="btn btn-primary" name="acao" value="salvar"><?= ($acao == 'editar') ? 'Editar Quadrado' : 'Criar Quadrado'; ?></button>
                            </center>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <table class="table mt-5" border="1px;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Lado</th>
                            <th>Cor</th>
                            <th>Tamanho</th>
                            <th>Desenho</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $quadrado = new Quadrado('2', '5', '#000000', 'px');
                            $consulta = $quadrado->buscarTodos();
                            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                echo "
                                <tr>
                                    <td>{$linha['id']}</td>
                                    <td>{$linha['lado']}</td>
                                    <td>{$linha['cor']}</td>
                                    <td>{$linha['tamanho']}</td>
                                    <td>";

                                    echo $quadrado->desenhar($linha['lado'],$linha['tamanho'],$linha['cor']);
                                    $resultado = $quadrado->calcular();
                                    $medida = $linha['tamanho'];
                                    echo "<br>Área do quadrado: " . $resultado['area'] ." $medida"."<br>";
                                    echo "Perímetro do quadrado: " . $resultado['perimetro']." $medida";
                            
                                    echo"</td>
                                    <td><a class='btn btn-warning' href='index.php?acao=editar&id={$linha['id']}'>Editar</a>
                                    <a class='btn btn-danger' onClick='return excluir();' href='index.php?acao=excluir&id={$linha['id']}'>Excluir</a></td>
                                </tr>\n";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

