<?php
    session_start();
    class Information{
        public function __construct(){
            $host="localhost";
            $username="root";
            $password="640087@m";
            $db_name="todo_list";
            $this->link=mysqli_connect($host,$username,$password,$db_name);
            if ($this->link==true){
                 //die("Sucessfully");
            }
            else{
                echo "Uncessfull, connection error!!!";
            }
        }
        public function save_task($data){
            $task=$data['task'];
            $query= "INSERT into todo_task(task) values('$task')";
            if(mysqli_query($this->link,$query)==true){
                echo "Sucessfully Added.<br>";
                header('Location: index.php');
            }else{
                echo "Unsucessful, not save.<br>";
                header('Location: index.php');
            }
        }

        public function show_taskList(){
            $query1= "SELECT * FROM todo_task_back_up";
            $value= mysqli_query($this->link,$query1);
            $value=mysqli_fetch_array($value);
            if (empty($value)){
                $query= "SELECT * FROM todo_task order by id ASC";
                $task_list=mysqli_query($this->link,$query);
                $cancel_list= "SELECT * FROM todo_task_back_up";
                $cancel_list_id=mysqli_query($this->link,$cancel_list);
                return [ 'task_list' => $task_list , 'cancel_list_id' => $cancel_list_id];
            }else{
                $query= "SELECT * FROM todo_task UNION ALL SELECT * FROM todo_task_back_up order by id ASC";
                $task_list=mysqli_query($this->link,$query);
                $cancel_list= "SELECT * FROM todo_task_back_up";
                $cancel_list_id=mysqli_query($this->link,$cancel_list);
                return [ 'task_list' => $task_list , 'cancel_list_id' => $cancel_list_id];
            }

        }

        public function delete_task($id){
            $data_by_id= "SELECT * FROM todo_task where id = '$id'";
            $value=mysqli_query($this->link,$data_by_id);
            $value=mysqli_fetch_array($value);
            $task=$value['task'];
            $query= "INSERT into todo_task_back_up(id,task) values('$id','$task')";
            mysqli_query($this->link,$query);
            $query= "DELETE FROM todo_task where id = '$id'";
            mysqli_query($this->link,$query);
            header('Location: index.php');
        }
        public function edit_task($data){

            $id= $data['id'];
            $task=$data['task'];

            $query= "UPDATE todo_task 
            SET task='$task' where id='$id'";
            if (mysqli_query($this->link,$query)){
                echo "Sucessfully Updated";
                header('Location:index.php');
            }else{
                echo "Uncessful";
                header('Location:index.php');
            }
        }

        public function types_task_list($data){

            if ($data['type']==1){
                header('Location: index.php');
            }
            elseif ($data['type']==2){
                $query= "SELECT * FROM todo_task order by id ASC";
                $task_list=mysqli_query($this->link,$query);
                $results = array();
                while($row = mysqli_fetch_assoc($task_list))
                {
                    $results[] = $row;
                }
                $task_list=$results;
                $task_list=json_encode($task_list);
                $queryCpount= "SELECT * FROM todo_task";
                $task_count=mysqli_query($this->link,$queryCpount);
                $t_count = array();
                while($row = mysqli_fetch_assoc($task_count))
                {
                    $t_count[] = $row;
                }
                $task_count=count($t_count);
                $cancel_list= "SELECT * FROM todo_task_back_up";
                $cancel_list_id=mysqli_query($this->link,$cancel_list);
                $result_cancel = array();
                while($row = mysqli_fetch_assoc($cancel_list_id))
                {
                    $result_cancel[] = $row;
                }
                $cancel_list_id=$result_cancel;
                $cancel_list_id=json_encode($cancel_list_id);
                header("Location: index.php?task_list=".$task_list."&type=".$data['type']."&task_count=".$task_count."&cancel_list_id=".$cancel_list_id);

            }
            elseif ($data['type']==3){
                $query= "SELECT * FROM todo_task_back_up order by id ASC";
                $task_list=mysqli_query($this->link,$query);
                $results = array();
                while($row = mysqli_fetch_assoc($task_list))
                {
                    $results[] = $row;
                }
                $task_list=$results;
                $task_list=json_encode($task_list);


                $queryCpount= "SELECT * FROM todo_task";
                $task_count=mysqli_query($this->link,$queryCpount);
                $t_count = array();
                while($row = mysqli_fetch_assoc($task_count))
                {
                    $t_count[] = $row;
                }
                $task_count=count($t_count);
                $cancel_list= "SELECT * FROM todo_task_back_up";
                $cancel_list_id=mysqli_query($this->link,$cancel_list);
                $result_cancel = array();
                while($row = mysqli_fetch_assoc($cancel_list_id))
                {
                    $result_cancel[] = $row;
                }
                $cancel_list_id=$result_cancel;
                $cancel_list_id=json_encode($cancel_list_id);
                header("Location: index.php?task_list=".$task_list."&type=".$data['type']."&task_count=".$task_count."&cancel_list_id=".$cancel_list_id);
            }
            elseif ($data['type']==4){
                $query= "DELETE FROM todo_task_back_up";
                mysqli_query($this->link,$query);
                $queryCpount= "SELECT * FROM todo_task";
                $task_count=mysqli_query($this->link,$queryCpount);
                $t_count = array();
                while($row = mysqli_fetch_assoc($task_count))
                {
                    $t_count[] = $row;
                }
                $task_count=count($t_count);
                header("Location: index.php?type=".$data['type']."&task_count=".$task_count);


            }
        }



    }

?>