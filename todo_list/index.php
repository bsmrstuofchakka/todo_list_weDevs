<?php
    require 'vendor/autoload.php';
    $obj = new Information();
    if (isset($_POST['submit'])){
        $obj->save_task($_POST);
    }
    $diff=0;
    if (isset($_GET['task_list'])&&!empty($_GET['task_list']) || isset($_GET['type'])&&!empty($_GET['type']) ){
        if (!empty($_GET['task_list']))
            $task_list = json_decode($_GET['task_list']);
         $type = json_decode($_GET['type']);
        if (!empty($_GET['cancel_list_id']))
            $cancel_list_id = json_decode($_GET['cancel_list_id']);
        $total_poriman=0;
         if (!empty($_GET['task_count'])){
             $total_poriman=$_GET['task_count'];
         }
         $diff=1;
    }else{

        $type32=1;
        $result=$obj->show_taskList();
        extract($result);
        $results = array();
        if (!empty($cancel_list_id)){
            while($row = mysqli_fetch_assoc($cancel_list_id))
            {
                $results[] = $row['id'];
            }
            $cancel_list_id=$results;
            $total_poriman= count($cancel_list_id);
        }


    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Todo List Application using Object Oriented PHP</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="heading">
        <h2>Todo List Application using Object Oriented PHP</h2>
    </div>
    <form class="form" method="post" action="index.php">
        <input type="text" name="task" class="taskInput" placeholder="what needs to be done?" required>
        <input style="position: absolute; left: -9999px" type="submit"  name="submit">
    </form>


    <table>
        <?php if ($diff==0) {?>
        <tbody style="margin-left: -5px;">
            <?php
                $i=0;
                if (!empty($task_list)){
                while($row= mysqli_fetch_assoc($task_list)){
                    ++$i;
           ?>
            <tr >
                <td style="text-align: right;" class="delete">
                    <a  <?php if (!empty($cancel_list_id) && array_keys($cancel_list_id,$row['id'])) { ?> style="padding: 1px 5px;border: 1px solid #d7c8c8; border-radius: 50%;color: green"   <?php } else  { ?>  style="padding: 1px 5px;border: 1px solid #d7c8c8; border-radius: 50%;" href="delete.php?id=<?= $row['id'] ?>" <?php } ?> >&#x2713</a>
                </td>




                    <form action="edit.php" method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                        <td  style="text-align: left;" class="task"> <input class="taskInputTd" type="text" <?php if (!empty($cancel_list_id) && array_keys($cancel_list_id,$row['id'])) { ?>  style="text-decoration: line-through;background-color: white;color: #dbcccc;" disabled <?php } else  { ?>  style="text-decoration: none" <?php } ?> name="task" required  value="<?php if (!empty($row['task'])) echo $row['task'] ?>"></td>
                    </form>


            </tr>
            <?php } } ?>


        </tbody>
        <?php }else{?>
            <tbody style="margin-left: -5px;">
            <?php
            $i=0;
            if (!empty($task_list)){
                foreach($task_list as $row){
                    ++$i;
                    ?>
                    <tr >
                        <td style="text-align: right;" class="delete">
                            <a  <?php if (!empty($type) && $type==3) { ?> style="padding: 1px 5px;border: 1px solid #d7c8c8; border-radius: 50%;color: green;"  <?php } else  { ?> style="padding: 1px 5px;border: 1px solid #d7c8c8; border-radius: 50%;"  href="delete.php?id=<?= $row->id ?>" <?php } ?>  >&#x2713</a>
                        </td>




                        <form action="edit.php" method="post">
                            <input type="hidden" name="id" value="<?= $row->id ?>" />
                            <td  style="text-align: left;" class="task"> <input class="taskInputTd" type="text" <?php if (!empty($type) && $type==3) { ?>  style="text-decoration: line-through;background-color: white;color: #dbcccc;" disabled <?php } else  { ?>  style="text-decoration: none" <?php } ?> name="task" required  value="<?php if (!empty($row->task)) echo $row->task ?>"></td>
                        </form>


                    </tr>
                <?php } } ?>


            </tbody>
        <?php }?>
    </table>
    <div style="margin: 30px auto; width: 50%;">
            <?php if (!empty($i) || !empty($type)) {?>
            <p style="display: inline"> <?php if (empty($diff)) echo abs($i-$total_poriman); else echo $total_poriman?> items left</p>
            <button  <?php if (!empty($type32)&&$type32==1){?> style="margin-left: 5%;background: white;" <?php } else {?> style="margin-left: 5%;" <?php }?> type="button"><a style="color: black;text-decoration: none;cursor: pointer;" href="typesOfList.php?type=1">All</a></button>
            <button  <?php if (!empty($type)&&$type==2){?> style="margin-left: 5%;background: white;" <?php } else {?> style="margin-left: 5%;" <?php }?> type="button"><a style="color: black;text-decoration: none;cursor: pointer;" href="typesOfList.php?type=2">Active</a></button>
            <button  <?php if (!empty($type)&&$type==3){?> style="margin-left: 5%;background: white;" <?php } else {?> style="margin-left: 5%;" <?php }?> type="button"><a style="color: black;text-decoration: none;cursor: pointer;" href="typesOfList.php?type=3">Completed</a></button>
            <?php if (!empty($cancel_list_id)) {?>
            <button style="float: right;"  type="button"><a style="color: black;text-decoration: none;cursor: pointer;" href="typesOfList.php?type=4">Clear Completed</a></button>
            <?php }?>

            <?php }?>
    </div>
</body>
</html>