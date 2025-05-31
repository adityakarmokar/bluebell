<div class="modal fade" id="tokenStatusChangeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tokenStatusChangeModalLabel1">Change Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="nameBasic" class="form-label">Token ID: <span id="Modal_token_id" class="badge bg-label-primary"></span></label>              
            </div>
            <div class="col-md-6 mb-3">
              <label for="nameBasic" class="form-label">Service: <span id="modal_service_change" class="badge bg-label-info"></span></label>              
            </div>
          </div>          
          <div class="row g-2">            
            <div class="col mb-0">                            
              <label for="dobBasic" class="form-label">Status</label>
              <input type="hidden" name="modal_token_status_change_id" id="modal_token_status_change_id" value="">
              <select id="get_modal_payment_status" class="select2 form-select token-status" name="modal_payment_status" data-allow-clear="true">  
                
              </select> 
            </div>
          </div>
  
          <div class="row mt-3" id="status4Modal" style="display: none;">
            <div class="col-md-12">
              <label for="refund_amount" class="form-label">Refund Amount</label>
              <input type="text" name="refund_amount" id="refund_amount_status" class="form-control" placeholder="50">
            </div>
            <div class="col-md-12">
              <label for="payable_amount" class="form-label">Payable Amount</label>
              <input type="text" name="payable_amount" id="payable_amount_status" class="form-control" placeholder="50">
            </div>
            <div class="col-md-12">
              <label for="consultency_fees" class="form-label">Consultency Fees</label>
              <input type="text" name="consultency_fees" id="consultency_fees_status" class="form-control" placeholder="50">
            </div>
            
            <div class="d-flex mt-3 justify-content-end">
              <button type="button" class="btn btn-primary" onclick="saveTokenStatus()">Save changes</button>
            </div>
          </div>
          
          
        </div>
        <div class="modal-footer" id="save-div">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="changetokenstatusbymodal">Save changes</button>
        </div>
      </div>
    </div>
</div>

