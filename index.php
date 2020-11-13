
    <?php
        require_once ('./config/dbconf.php');
        require_once ('./vendor/autoload.php');
        $edit = new \Core\EditTask($pdo);

        if (isset($_REQUEST['act'])){
            $act = $_REQUEST['act'];
        }
        if (isset($_REQUEST['id'])){
            $id = $_REQUEST['id'];
        }
        if (isset($_REQUEST['name'])){
            $name = $_REQUEST['name'];
        }

        switch ($act)
        {
            case 'list':
                dbg($pdo);
                break;
            case 'add':
                if (!empty($name))
                {
                    $edit->addTask($name);
                }
                dbg($pdo);
                break;
            case 'delete':
                if (!empty($id))
                {
                    $edit->deleteTask($id);
                }
                dbg($pdo);
                break;
            case 'complete':
                if (!empty($id))
                {
                    $edit->completeTask($id);
                }
                dbg($pdo);
                break;
            case 'decomplete':
                if (!empty($id))
                {
                    $edit->decompleteTask($id);
                }
                dbg($pdo);
                break;
            case 'edit':
                if (!empty($id) and !empty($name))
                {
                    $edit->editTask($id, $name);
                }
                dbg($pdo);
                break;
            default :
                dbg($pdo);
        }

        function dbg($pdo)
        {
            ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ToDo</title>
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </head>
    <body>
    <div class="container">
        <h1>ToDo:</h1>
        <form method="POST">
            <input class="form-control" type="text" name="name" id ="name" placeholder="Введите текст заметки..." value=''>
            <input type="hidden" name="act" id="act" value="add"/>
            <br>
            <button class="btn btn-danger" type="submit" name="send"> Добавить </button>
        </form>
        <ul>
            <?php
        $query = $pdo->query('SELECT * FROM `tasks`');
        while($tmp = $query->fetch(PDO::FETCH_OBJ)) {
            ?><li>
            <?php if ($_REQUEST['act'] == 'edita' and $_REQUEST['id'] == $tmp->id): ?>
                <form method="POST">
                    <input class="form-control" type="text" name="name" id ="name" placeholder="Введите текст заметки..." value='<?php echo $tmp->task; ?>'>
                    <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>"/>
                    <input type="hidden" name="act" id="act" value="edit"/>
                    <br>
                    <button class="btn btn-danger" type="submit" name="send"> Сохранить </button>
                </form>
            <?php elseif($tmp->done==1): ?>
            <b>
                <b><?php echo $tmp->task; ?></b>
                <br>
                <br>
                <form method="post">
                    <input type="hidden" name="id" id="id" value="<?php echo $tmp->id; ?>"/>
                    <input type="hidden" name="act" id="act" value="delete"/>
                    <button class="btn btn-danger" type="submit" name="send"> Удалить</button>
                </form>
                <form method="post">
                    <input type="hidden" name="id" id="id" value="<?php echo $tmp->id; ?>"/>
                    <input type="hidden" name="act" id="act" value="decomplete"/>
                    <button  class="btn btn-dark" type="submit" name="send"  <?php echo $tmp->done; ?>> Сделано</button>
                </form>
                <form method="post">
                    <input type="hidden" name="id" id="id" value="<?php echo $tmp->id; ?>"/>
                    <input type="hidden" name="act" id="act" value="edita"/>
                    <button class="btn btn-info" type="submit" name="send"> Редактировать</button>
                </form>
            </b>
            <?php else: ?>
                <b><?php echo $tmp->task; ?></b>
                <br>
                <br>
                <form method="post">
                    <input type="hidden" name="id" id="id" value="<?php echo $tmp->id; ?>"/>
                    <input type="hidden" name="act" id="act" value="delete"/>
                    <button class="btn btn-danger" type="submit" name="send"> Удалить</button>
                </form>
                <form method="post">
                    <input type="hidden" name="id" id="id" value="<?php echo $tmp->id; ?>"/>
                    <input type="hidden" name="act" id="act" value="complete"/>
                    <button class="btn btn-success" type="submit" name="send"  <?php echo $tmp->done; ?>> Выполнить</button>
                </form>
                <form method="post">
                    <input type="hidden" name="id" id="id" value="<?php echo $tmp->id; ?>"/>
                    <input type="hidden" name="act" id="act" value="edita"/>
                    <button class="btn btn-info" type="submit" name="send"> Редактировать</button>
                </form>
            <?php endif;?>

                </li><?php
        }?>
        </ul>

    </div>
    </body>
    </html>
    <?php
        }
