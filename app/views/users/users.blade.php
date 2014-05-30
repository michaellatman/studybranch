@extends('/users/layout')

@section('content')
    Users!
    <?php
        if(isset($_GET['d'])){
            echo("The capital of new york is YOU! ".$_GET['d']);
        }

    ?>
@stop