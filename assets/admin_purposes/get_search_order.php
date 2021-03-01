<?php 
	
		$search_text = $_GET['search'];  # could be user's email, full name or nºBI.
		$search_by = $_GET['search_by'];  # user's selected option


		$get_user_orders = [];
		$order = false;

		if($search_by == 'user_email') {
			$query_email = $db->query("SELECT * FROM encomendas WHERE emailCliente = '$search_text' AND finalizado = 1");

			while($row = $query_email->fetch_object()) {
				$get_user_orders[] = $row;
			}

			$order = true;
		}
		else if ($search_by == 'user_BI') {
			$query_BI = $db->query("SELECT emailCliente FROM clientes WHERE numBi = '$search_text'")->fetch_object();
			$email = $query_BI->emailCliente;
			$query_email = $db->query("SELECT * FROM encomendas WHERE emailCliente = '$email' AND finalizado = 1");

			while($row = $query_email->fetch_object()) {
				$get_user_orders[] = $row;
			}

			$order = true;
		}
		else {
			$query_user = $db->query("SELECT pNomeCliente, uNomeCliente, emailCliente FROM clientes");
			$temp_email = [];
			$temp_name = [];

			while($row = $query_user->fetch_object()) {
				$temp_name[] = $row->pNomeCliente . ' ' . $row->uNomeCliente;
				$temp_email[] = $row->emailCliente;
			}

			$email = [];
			$name = [];

			$temp_name = preg_replace("/[^A-Za-z ]/", ' ', $temp_name); # This pattern removes anything that's not alphabetical 
			$temp_name = preg_replace('/\s+/', ' ',$temp_name); # This pattern removes extra whitespace, p.e 2 spaces are converted into a single space

			for ($i=0; $i < sizeof($temp_name); $i++) { 
				if (strtolower($search_text) == strtolower($temp_name[$i])) {
					$email[] = $temp_email[$i];
					$name[] = $temp_name[$i];
				}
			}

			$order = false;
		}
 ?>