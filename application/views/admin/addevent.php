<div class="container">
  <div class="col-md-12">

	<div class="col-md-3">
		<div class="form-class">
			<label>EventName</label>
      <input type="text" id="title" class="form-control" required>
      <span class="titleerr"></span>
		</div>
		<div class="form-class">
			<label>StartDate</label>
      <input type="text" id="fdate" class="form-control" required>
      <input type="hidden" id="hid">
        <span class="sdateerr"></span>
		</div>
		<div class="form-class">
			<label>EndDate</label>
      <input type="text" id="tdate" class="form-control" required>
      <span class="edateerr"></span>

		</div>
        <div class="form-class">
            <input type="button" id="add" value="add" class="btn btn-primary">
    </div>

	</div>
  <div class="row" style="width:100%">
       <div class="col-md-8">
           <div id="calendar"></div>
       </div>
    </div>
  </div>
  <br>
        <table class="table table-bordered " style='margin-top:5%;'><thead><tr><th>Title</th><th>StartDate</th><th>EndDate</th><th></th></thead>
    <tbody class="eventdata">
    <?php
    if(!empty($data)){
       for ($i=0; $i <count($data) ; $i++) {
          $title = $data[$i]["title"];
          $id    = $data[$i]["id"];
          $s_date = $data[$i]["start"];
          $e_date = $data[$i]["end"];
          $sdate = date("Y/m/d h:m:s", strtotime($s_date));
          $edate = date("Y/m/d h:m:s", strtotime($e_date));
          $j = $i+1; 
         echo "<tr><td>$title</td><td>$sdate</td><td>$edate</td><td><input type='button' class='update btn btn-primary' value='update' target='$id' title='$title' sdate='$sdate' edate='$edate'></td></tr>";
       }
      }
      else
      {
        echo "<tr><td colspan='4'>No data found</td></tr>";
      }
    ?>
  </tbody></table> 


</div>
<style type="text/css">
  .form-class span{
    color:red;
    font:bold;
  }
</style>
  <script>
  	var dateToday = new Date();

  $(document).ready(function() {
    /*date*/
    $( "#fdate").datetimepicker({        

        minDate:dateToday,
        onShow: function () {
            this.setOptions({
                maxDate:$('#tdate').val()?$('#tdate').val():false,
                maxTime:$('#tdate').val()?$('#tdate').val():false
            });
}
     }).attr('readonly', 'readonly');    


      $("#tdate").datetimepicker({
        onShow: function () {
            this.setOptions({
                minDate:$('#fdate').val()?$('#fdate').val():false,
                minTime:$('#fdate').val()?$('#fdate').val():false
            });
        }                    
  }).attr('readonly', 'readonly');    

  

/*calender code*/
var events="";
<?php if(!empty($data)){?>
  events = <?php echo json_encode($data); ?>;
    <?php }?>
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
           
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },

      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      events    : events,
      eventClick: function (event) {
            var confimit = confirm("Do you really want to delete?");
            console.log(event,event.id);
            if (confimit) {
        
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url()?>delete_event",
                    data: "&id=" + event.id,
                    success: function (response) {
                        if(parseInt(response) > 0) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            displayMessage("Deleted Successfully");
                        }
                    }
                });
            }
        }
        ,
      editable: true,
     

  /*eventDrop: function(info) {
                  alert("Ddf");
                },
                */
    });
/*add code*/
    $("#add").click(function(){
      var title   = $("#title").val();
      var sdate   = $("#fdate").val();
      var edate   = $("#tdate").val();
      var hid     = $("#hid").val(); 
      console.log(title,sdate,edate);
      var count=0;
     if(title==""){
      $(".titleerr").html("Please enter Title");
     count=1;
     }
     else
     {
      $(".titleerr").html("");
     }
     
    if(sdate==""){
      $(".sdateerr").html("Please enter Startdate");
     count=1;
     }
     else
     {
        $(".sdateerr").html("");

     }
     
      if(edate==""){
      $(".edateerr").html("Please enter Enddate");
     count=1;
     }
     else
     {
            $(".edateerr").html("");

     }
    console.log(count);
     if((count==0)&&(hid=="")){
      $.ajax({
        url:"<?php echo base_url()?>addeventdata",
        type:"post",
        data:{"title":title,"sdate":sdate,"edate":edate},
        success:function(data){
          console.log(data);
              //Get all client events
        var allEvents = $('#calendar').fullCalendar('clientEvents');

        var userEventIds= [];

        //Find ever non usercreated event and push the id to an array
        $.each(allEvents,function(index, value){
            if(value.isUserCreated !== true){
        $('#calendar').fullCalendar('removeEvents', value.id);
            }
        });

        //Remove events with ids of non usercreated events

        $('#calendar').fullCalendar('removeEvents', userEventIds);
          var source = JSON.parse(data);
          $('#calendar').fullCalendar( 'addEventSource',source);
          $("#title").val("");
          $("#fdate").val("");
          $("#tdate").val("");
          $(".eventdata").empty("");
          var eventcount=0;
          $.each(source,function(key,val){
              
             $(".eventdata").append("<tr><td>"+val.title+"</td><td>"+val.start+"</td><td>"+val.end+"</td><td><input type='button' class='update btn btn-primary' value='update' target="+val.id+" title='"+val.title+"' sdate='"+val.start+"' edate='"+val.end+"'></td></tr>");
 
          })

          },error:function(data){

        }
      })
    }
    /*update event*/
    else if((count == 0)&&(hid!="")){
           $.ajax({
        url:"<?php echo base_url()?>updateeventdata",
        type:"post",
        data:{"title":title,"id":hid,"sdate":sdate,"edate":edate},
        success:function(data){
          console.log(data);
              //Get all client events
        var allEvents = $('#calendar').fullCalendar('clientEvents');

        var userEventIds= [];

        //Find ever non usercreated event and push the id to an array
        $.each(allEvents,function(index, value){
            if(value.isUserCreated !== true){
        $('#calendar').fullCalendar('removeEvents', value.id);
            }
        });

        //Remove events with ids of non usercreated events

        $('#calendar').fullCalendar('removeEvents', userEventIds);
          var source = JSON.parse(data);
          var maind =  JSON.stringify(source);
          $('#calendar').fullCalendar( 'addEventSource',source);
          $("#title").val("");
          $("#fdate").val("");
          $("#tdate").val("");
          $(".eventdata").empty("");
          var eventcount=0;
        $.each(source,function(key,val){
              
             $(".eventdata").append("<tr><td>"+val.title+"</td><td>"+val.start+"</td><td>"+val.end+"</td><td><input type='button' class='update btn btn-primary' value='update' target="+val.id+" title='"+val.title+"' sdate='"+val.start+"' edate='"+val.end+"'></td></tr>");
 
          })
          },error:function(data){
           
        }
      })

    }
    else
    {
      return false;
    }
    });
/*update evtnt*/
$(".eventdata").on("click",".update", function() { 
    $(window).scrollTop(0);


      var id    = $(this).attr("target");
      var title = $(this).attr("title");
      var sdate = $(this).attr("sdate");
      var edate = $(this).attr("edate"); 

      $("#title").val(title);
      $("#fdate").val(sdate);
      $("#tdate").val(edate);
      $("#hid").val(id);
    });

  });   
function displayMessage(message) {
      $(".response").html("<div align='center' style='padding:20px;font-size:18px;color:#3539EA' class='success'>"+message+"</div>");
    setInterval(function() { $(".success").fadeOut(); }, 2000);
}
  </script>

 
