<?php
/**
* Holding an instance of CLydia to enable use of $this in subclasses.
*
* @package OlinaCore
*/
class CObject 
{

	   public $config;
	   public $request;
	   public $data;
	   public $db;
	   public $views;
	   public $session;
	
	   /**
	    * Constructor
	    */
	   protected function __construct() 
	   {
		   $olina = COlina::Instance();
		   $this->config   = &$olina->config;
		   $this->request  = &$olina->request;
		   $this->data     = &$olina->data;
		   $this->db       = &$olina->db;
		   $this->views    = &$olina->views;
		   $this->session  = &$olina->session;
	   }
	/**
	* Redirect to another url and store the session
	*/
	protected function RedirectTo($url) 
	{
		$olina = COlina::Instance();
		if(isset($olina->config['debug']['db-num-queries']) && $olina->config['debug']['db-num-queries'] && isset($olina->db)) 
		{
			$this->session->SetFlash('database_numQueries', $this->db->GetNumQueries());
		}
		if(isset($olina->config['debug']['db-queries']) && $olina->config['debug']['db-queries'] && isset($olina->db)) 
		{
			$this->session->SetFlash('database_queries', $this->db->GetQueries());
		}
		if(isset($olina->config['debug']['timer']) && $olina->config['debug']['timer']) 
		{
			$this->session->SetFlash('timer', $olina->timer);
		}
		$this->session->StoreInSession();
		header('Location: ' . $this->request->CreateUrl($url));
	}
}


