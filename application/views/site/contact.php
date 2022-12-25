<div class="inner_header">
   <div class="container">
      <h2>Contact Us</h2>
      <ul class="ul_set">
         <li><a href="<?=site_url();?>">Home</a></li>
         <li><span>Contact Us</span></li>
      </ul>
   </div>
</div>
<div class="sec_pad contact_uss">
   <div class="container">
      <div class="box_d3">
         <div class="row">
            <div class="col-md-5">
               <div class="box_4">
                  <div class="conten_set">
                     <h2>
                        Get In Touch
                     </h2>
                     <p>
                        Are you a Startup, Enterprise, or an Investor looking for
                        technology partners? We are here to help you.
                        <ul class="ul_set socila_foo" style="text-align: left;">
                           <?php
                              foreach($socialAccounts as $socialAccount){
                           ?>
                              <li><a href="<?=$socialAccount['url'];?>" target="_blank"><i class="fa fa-<?=$socialAccount['icon'];?>"></i></a></li>
                           <?php
                              }
                           ?>
                        </ul>
                     </p>
                  </div>

                  <div class="ion_left">
                     <i class="fa fa-envelope"></i>
                     <h4>Email</h4>
                     <p>
                        <a href="mailto:<?=$this->config->item('EMAIL');?>"><?=$this->config->item('EMAIL');?></a>
                     </p>
                  </div>
                  <div class="ion_left">
                     <i class="fa fa-phone"></i>
                     <h4>Phone</h4>
                     <p>
                        <a href="tel:<?=$this->config->item('PHONE');?>"><?=$this->config->item('PHONE');?></a>
                     </p>
                  </div>
                  <div class="ion_left">
                     <i class="fa fa-map-marker"></i>
                     <h4>Address</h4>
                     <p>
                        <?=$this->config->item('ADDRESS');?>
                     </p>
                  </div>
                  <div class="ion_left">
                      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28272.892449095314!2d77.25277384358654!3d27.652020064219478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39731edb7cbdf48b%3A0x555da5c5661eb68a!2sKaman%2C%20Rajasthan%20321022!5e0!3m2!1sen!2sin!4v1667138343510!5m2!1sen!2sin" width="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
               </div>
            </div>
            <div class="col-md-7">
               <div class="box_4">
                  <div class="conten_set">
                     <h2>
                        Send me message
                     </h2>
                  </div>
                  <form id="contactUsForm" name="contactUsForm" method="POST" onsubmit="send_contact(event);" >
                     <div class="row ">
                        <div class="col-sm-6">
                           <div class="mb-3">
                              <label>Name</label>
                              <div class="ion_in">
                                 <i class="fa fa-user-o"></i>
                                 <input type="text" name="user_name" class="form-control" placeholder="Name" id="name" required="">
                              </div>
                              <p class=" text-danger" style="display:none" id="alte_name">Please enter valid Username</p>
                              <p class=" text-danger" style="display:none" id="alte_name2">Sorry first space is not allowed</p>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="mb-3">
                              <label>Email</label>
                              <div class="ion_in">
                                 <i class="fa fa-envelope-o"></i>
                                 <input type="email" name="email" class="form-control" placeholder="Email" id="email" required="">
                              </div>
                              <p class=" text-danger" style="display:none" id="alte_email">Please enter valid Email</p>
                              <p class=" text-danger" style="display:none" id="alte_email3">Sorry first space is not allowed</p>
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
                           <textarea class="form-control textarea" name="message" placeholder="Message" id="message" required="" ></textarea>
                        </div>
                     </div>
                     <div id="responseMessage"></div>
                     <div class="">
                        <button class="btn btn_theme btn-block btn-lg btn_submit" type="submit" >Submit</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include_once('include/tinymce.php'); ?>

<script>
   function send_contact(e){
      e.preventDefault();
      $.ajax({
      type: 'POST',
      url: BASE_URL + 'Contact-Admin',
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
        if (response.status == 1){
         $('form#contactUsForm').trigger("reset");
        }
      }
    });
   }
</script>