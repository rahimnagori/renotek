<div class="inner_header">
   <div class="container">
      <h2>Cart</h2>
      <ul class="ul_set">
         <li><a href="<?= site_url(); ?>">Home</a></li>
         <li><span>Cart</span></li>
      </ul>
   </div>
</div>
<div class="sec_pad contact_uss">
   <div class="container">
      <div class="box_d3">
         <div class="row">
            <div class="col-sm-5">
               <div class="vieew_acart">
                  <?php
                  foreach ($cartProducts as $serialNumber => $cartProduct) {
                     $productImage = (isset($cartProduct['product_image']) && file_exists($cartProduct['product_image'])) ? $cartProduct['product_image'] : 'assets/site/img/img5.png';
                  ?>
                     <div class="carr_img">
                        <img src="<?= site_url($productImage); ?>">
                        <h4><?= $cartProduct['product_title']; ?></h4>
                     </div>
                  <?php
                  }
                  ?>
               </div>
            </div>
            <div class="col-sm-7">
               <div class="box_4">
                  <div class="conten_set">
                     <h2>
                        Send Quotation
                     </h2>
                  </div>
                  <form id="contactUsForm" name="contactUsForm" method="POST" onsubmit="send_contact(event);">
                     <div class="row ">
                        <div class="col-sm-6">
                           <div class="mb-3">
                              <label>Name</label>
                              <div class="ion_in">
                                 <i class="fa fa-user-o"></i>
                                 <input type="text" name="user_name" class="form-control" placeholder="Name" id="name" required="">
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="mb-3">
                              <label>Email</label>
                              <div class="ion_in">
                                 <i class="fa fa-envelope-o"></i>
                                 <input type="email" name="email" class="form-control" placeholder="Email" id="email" required="">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="mb-3">
                        <label>Number</label>
                        <div class="ion_in">
                           <i class="fa fa-phone"></i>
                           <input type="number" name="phone" class="form-control" placeholder="Number" required="">
                        </div>
                     </div>
                     <div class="mb-3">
                        <label>Message</label>
                        <div class="ion_in">
                           <i class="fa fa-edit"></i>
                           <textarea class="form-control textarea" name="message" placeholder="Message" id="message" required=""></textarea>
                        </div>
                     </div>
                     <div class="">
                        <button class="btn btn_theme btn-block btn-lg btn_submit" type="submit">Send</button>
                     </div>
                  </form>
                  <div id="responseMessage"></div>
                  <form id="codeForm" name="codeForm" class="hideElement" method="post" onsubmit="submit_code(event);">
                     <div class="form-group">
                        <label for="">Enter Code</label>
                        <input type="text" name="token" class="form-control" required />
                     </div>
                     <button type="submit" class="btn btn_theme btn-block btn_code">Submit</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   function send_contact(e) {
      e.preventDefault();
      $.ajax({
         type: 'POST',
         url: BASE_URL + 'Send-Quotation',
         data: new FormData($('#contactUsForm')[0]),
         dataType: 'JSON',
         processData: false,
         contentType: false,
         cache: false,
         beforeSend: function(xhr) {
            $(".btn_submit").attr('disabled', true);
            $(".btn_submit").html(LOADING);
            $("#responseMessage").html('');
            $("#responseMessage").hide();
         },
         success: function(response) {
            $(".btn_submit").prop('disabled', false);
            $(".btn_submit").html('Submit');
            $("#responseMessage").html(response.responseMessage);
            $("#responseMessage").show();
            if (response.status == 1) {
               $("#contactUsForm").addClass('hideElement');
               $("#codeForm").removeClass('hideElement');
            }
         }
      });
   }

   function submit_code(e) {
      e.preventDefault();
      $.ajax({
         type: 'POST',
         url: BASE_URL + 'Submit-Code',
         data: new FormData($('#codeForm')[0]),
         dataType: 'JSON',
         processData: false,
         contentType: false,
         cache: false,
         beforeSend: function(xhr) {
            $(".btn_code").attr('disabled', true);
            $(".btn_code").html(LOADING);
            $("#responseMessage").html('');
            $("#responseMessage").hide();
         },
         success: function(response) {
            $(".btn_code").prop('disabled', false);
            $(".btn_code").html('Submit');
            $("#responseMessage").html(response.responseMessage);
            $("#responseMessage").show();
            if (response.status == 1) {
               $("#contactUsForm").removeClass('hideElement');
               $("#codeForm").addClass('hideElement');
               $('form#contactUsForm').trigger("reset");
               $('form#codeForm').trigger("reset");
               $("#cart-counter").html(0);
               $(".vieew_acart").html('');
            }
         }
      });
   }
</script>