<?php
session_start();
include_once("conexao.php");
//Verificar se está vindo a variável id pela URL
if(isset($_GET['id'])){
	if(isset($_COOKIE['voto_cont'])){
		$_SESSION['msg'] = "<span style='color: red'>Você já votou!</span>";
		header("Location: index.php");
	}else{
		setcookie('voto_cont', $_SERVER['REMOTE_ADDR'], time() + 5);
		$result_produto = "UPDATE produtos SET qnt_voto=qnt_voto + 1
		WHERE id ='".$_GET['id']."'"; 
		$resultado_produto = mysqli_query($conn, $result_produto);
		
		if(mysqli_affected_rows($conn)){
			$_SESSION['msg'] = "<span style='color: green'>Voto recebido com sucesso!</span>";
			header("Location: index.php");
		}else{
			$_SESSION['msg'] = "<span style='color: red'>Erro ao votar!</span>";
			header("Location: index.php");
		}
	}
}