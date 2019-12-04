<?php


/**
 * Class Modal
 */
class Modal {
    /**
     * @var string
     */
    private $prefix;
    /**
     * @var int
     */
    private $id;
    /**
     * @var null
     */
    private $modal = null;
    /**
     * @var string
     */
    private $message;
    /**
     * @var string
     */
    private $idModal;

    private $idCmde;

    /**
     * Modal constructor.
     * @param int $id
     * @param string $prefix
     * @param string $message
     */
    public function __construct(int $id, string $prefix, string $message, int $idCmde = null){
        $this->id = $id;
        $this->idModal = $prefix . '' . $id;
        $this->message = $message;
        $this->prefix = $prefix;
        $this->idCmde = $idCmde;
    }

    /**
     * Méthode qui permet de créer un modal
     */
    public function createModal() {
        $this->modal .= <<<HTML
        <div class="modal fade" id="{$this->idModal}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>{$this->message}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                <a href="delete.php?entity={$this->prefix}&id={$this->id}"><button type="button" class="btn btn-success">Confirmer</button></a>
              </div>
            </div>
          </div>
        </div>
HTML;
    }

    public function createModalPanier(){
        $this->modal .= <<<HTML
        <div class="modal fade" id="{$this->idModal}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>{$this->message}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                <a href="panier/delete.php?idCmde={$this->idCmde}&pizza={$this->id}"><button type="button" class="btn btn-success">Confirmer</button></a>
              </div>
            </div>
          </div>
        </div>
HTML;
    }

    /**
     * Méthode qui retourne le modal
     * @return string
     */
    public function getModal():string {
        if($this->modal != null){
            return $this->modal;
        }
    }

}