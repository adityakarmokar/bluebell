<div class="modal fade" id="tokenAmountChangeModal" tabindex="-1" aria-hidden="true">
  <form id="tokenAmountForm">    
    
    <input type="hidden" name="tokenId_amount" id="tokenId_amount" value="">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tokenAmountChangeModalLabel1">Change Amount</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">          
  
          <div class="row mt-3" id="amount4Modal">
            <div class="col-md-12">
              <label for="refund_amount" class="form-label">Refund Amount</label>
              <input type="text" name="refund_amount" id="refund_amount_amount" class="form-control" placeholder="50">
            </div>
            <div class="col-md-12">
              <label for="payable_amount" class="form-label">Payable Amount</label>
              <input type="text" name="payable_amount" id="payable_amount_amount" class="form-control" placeholder="50">
            </div>
            <div class="col-md-12">
              <label for="consultency_fees" class="form-label">Consultancy Fees</label>
              <input type="text" name="consultency_fees" id="consultency_fees_amount" class="form-control" placeholder="50">
            </div>            
          </div>          
          
        </div>
        <div class="modal-footer" id="save-div">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="changetokenamountbymodal">Save changes</button>
        </div>
      </div>
    </div>
  </form>
</div>

