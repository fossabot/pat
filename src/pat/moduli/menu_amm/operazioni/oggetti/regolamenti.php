<?include_once 'pat/moduli/menu_amm/operazioni/oggetti/OperazioneDefault.php';class regolamenti extends OperazioneDefault {		public function __construct() { }		public function postInsert($arrayParametri = array()) {	}		public function postDelete($arrayParametri = array()) {	}		private function inserisciRecordAtto() {		global $database, $dati_db, $enteAdmin;				$sql = "SELECT * FROM ".$dati_db['prefisso']."oggetto_regolamenti WHERE id_ente = ".$enteAdmin['id']." ORDER BY id DESC LIMIT 1";		if(!($result = $database->connessioneConReturn($sql))) {}		$record = $database->sqlArray($result);				$atto = caricaDocumentoEAlbo('atti', $_POST['id_atto_albo']);				$sql = "INSERT INTO etrasp_atti_ealbo (id_ente, id_ente_albo, id_atto_albo, id_oggetto, id_documento, ultima_modifica) 				VALUES (".$enteAdmin['id'].", ".$enteAdmin['id_ente_albo'].", ".$_POST['id_atto_albo'].", 19, ".$record['id'].", ".$atto['ultima_modifica'].")";		if(!($result = $database->connessioneConReturn($sql))) {}				collegaAttoEtrasparenza($_POST['id_atto_albo'], 1, $enteAdmin);	}		private function eliminaRecordAtto() {		global $database, $dati_db, $enteAdmin;				$cancello = isset($_POST['id_cancello_tabella']) ? $_POST['id_cancello_tabella'] : 0;		$arrayOggetti = explode(",", $cancello);		$arrayOggettiAlbo = array();		$numeroOggetti = count($arrayOggetti)-1;		$condizione = 'id_documento='.$arrayOggetti[0];		$arrayOggettiAlbo[] = getIdRecordAtto($enteAdmin['id'], $enteAdmin['id_ente_albo'], $arrayOggetti[0], 19);		for ($i=1;$i<$numeroOggetti+1;$i++) {			if ($arrayOggetti[$i] != '') {				$condizione .= ' OR id_documento='.$arrayOggetti[$i];				$arrayOggettiAlbo[] = getIdRecordAtto($enteAdmin['id'], $enteAdmin['id_ente_albo'], $arrayOggetti[$i], 19);			}		}		$sql = "DELETE FROM ".$dati_db['prefisso']."etrasp_atti_ealbo WHERE id_ente = ".$enteAdmin['id']." AND id_ente_albo = ".$enteAdmin['id_ente_albo']." AND id_oggetto = 19 AND (".$condizione.")";		if(!($result = $database->connessioneConReturn($sql))) {}				foreach((array) $arrayOggettiAlbo as $id) {			collegaAttoEtrasparenza($id, 0, $enteAdmin);		}	}}?>