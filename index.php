

<!DOCTYPE html>
<html>
<head>
<title>Getting Latitude and longitude from an image</title>

<style>
        input{
        border: 1px solid #ccc;
        padding: 4px 5px;
        margin-top: 10px;
        border-radius: 2px;
        }
        p{
        background: #ccc;
        padding: 10px;
        font-size: 17px;
        color: #F44336;
        width: 231px;
        border-radius: 2px;
        }
        img#preview {
    border: 2px dotted red;
}
img{
    cursor:pointer;
}
 .uploadSec{
            width: 300px;
    border: 1px solid;
    margin-top: 10px;
    padding-bottom: 10px;
    padding-left: 10px;
        }
        i{
            color : red;
        }
    </style>
    <!--exif Library to fetch latitude, longitude and camera details-->
    <script src="exif.min.js"></script>
</head>
<body>

 <h2>Fetching Latitude and longitude from Image</h2>
    
    <img src="IMG_20200222_154426.jpg" class="DisplayImage"  alt="" height="260px"/>
    <img src="angular.png" class="DisplayImage"  alt="" height="260px"/>
    <img src="" class="" id="preview"  alt="Uploaded image" height="260px"/><br>
    <i>Click on image to display the Details</i>
       <div class="uploadSec">
    <label for="uploadFile">Upload Image Here</label><br>
    <input type="file" id="uploadFile"  accept="image/*"/><br>
</div>
<div class="details">
     <p>Latitude : <span id="Lati"></span> </p>
    <p>Longitude : <span id="Long"></span></p>
    <p>Camera Model / Maker : <span id="cmm"></span></p>
    <p>Height x Width : <span id="resolution"></span></p>
    <p>Capture Time : <span id="datetime"></span></p>
    <p>ISO SpeedRatings : <span id="iso"></span></p>
    <p>Shuttor Speed : <span id="stp"></span></p>
</div>

    <script>
    (function () {
      
        document.getElementById("uploadFile").onchange = function(el) {
            readURL(this)
                EXIF.getData(el.target.files[0], function() {
                 
                   EXIF.getData(this,()=>{
                       console.log(this)
                       
                       
                       
                    if(Object.keys(this.exifdata).length > 0){
                        
                    //display camera details    
                      camera_details(this.exifdata)
                      //display image details
                    generate_lat_lang(this)
                    
                
              
                }else{
                     noDataAvailable()
                    }
   
                    });
    
                });
            }
            var image = document.getElementsByClassName('DisplayImage');
        for (var i = 0; i < image.length; i++) {
            image[i].addEventListener('click', function(){
                EXIF.getData(this,()=>{
            if(Object.keys(this.exifdata).length > 0){
                     //display camera details    
                      camera_details(this.exifdata)
                      //display image details
                    generate_lat_lang(this)
            }else{
              noDataAvailable()
               
            }
        });
            });
        }
    
      
    })();
    
    
    function readURL(input) {
        ///reading the Uploading file
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById("preview").src=  e.target.result
        }
        
        reader.readAsDataURL(input.files[0]);
      }
    }
    
    function noDataAvailable(){
        
        document.getElementById("Lati").innerText = "N/A"
        document.getElementById("Long").innerText = "N/A"
        document.getElementById("cmm").innerText = "N/A"
        document.getElementById("resolution").innerText = "N/A"
        document.getElementById("datetime").innerText = "N/A"
        document.getElementById("iso").innerText = "N/A"
        document.getElementById("stp").innerText = "N/A"
        alert("No GPS Data Available")
    }
    
    //getting camera details 
   function camera_details(exifData=''){
                        var cmm = "N/A"
                        var company = "N/A"
                        if(exifData.Model){
                           cmm =  exifData.Model;
                        }
                         if(exifData.Make){
                           company =  exifData.Make;
                        }
        
        //Camera Model
        document.getElementById("cmm").innerText = cmm+'-'+company
        //Image Resolution
        document.getElementById("resolution").innerText = (exifData.ImageHeight) ? exifData.ImageHeight : "N/A" +' '+ (exifData.ImageWidth) ? exifData.ImageWidth : "N/A"
        //Image taken time
        document.getElementById("datetime").innerText = (exifData.DateTimeOriginal) ? exifData.DateTimeOriginal : "N/A"
        //Iso speed
        document.getElementById("iso").innerText = (exifData.ISOSpeedRatings) ? exifData.ISOSpeedRatings : "N/A"
        //lense shutter speed
        document.getElementById("stp").innerText = (exifData.ShutterSpeedValue) ? exifData.ShutterSpeedValue : "N/A"
        
            }
    
    function generate_lat_lang(imageData=''){
       
//geting cordinates of latitude
    var latDegree = imageData.exifdata.GPSLatitude[0].numerator;
    var latMinute = imageData.exifdata.GPSLatitude[1].numerator;
    var latSecond = imageData.exifdata.GPSLatitude[2].numerator/imageData.exifdata.GPSLatitude[2].denominator;
    
    document.getElementById("Lati").innerText = (latDegree + (latMinute/60) + (latSecond/3600)).toFixed(8);;

    
//geting cordinates of longitude
    var lonDegree = imageData.exifdata.GPSLongitude[0].numerator;
    var lonMinute = imageData.exifdata.GPSLongitude[1].numerator;
    var lonSecond = imageData.exifdata.GPSLongitude[2].numerator/imageData.exifdata.GPSLongitude[2].denominator;
    document.getElementById("Long").innerText = (lonDegree + (lonMinute/60) + (lonSecond/3600)).toFixed(8);
             
    }

    </script>
</body>
</html>
