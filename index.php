


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
 .uploadSec{
            width: 300px;
    border: 1px solid;
    margin-top: 10px;
    padding-bottom: 10px;
    padding-left: 10px;
        }
    </style>
    <script src="exif.min.js"></script>
</head>
<body>

 <h2>Fetching Latitude and longitude from Image</h2>
    
    <img src="IMG_20200222_154426.jpg" class="DisplayImage"  alt="" height="260px"/>
    <img src="angular.png" class="DisplayImage"  alt="" height="260px"/>
    <img src="" class="" id="preview"  alt="Uploaded image" height="260px"/><br>
       <div class="uploadSec">
    <label for="uploadFile">Upload Image Here</label><br>
    <input type="file" id="uploadFile"  accept="image/*"/><br>
</div>
     <p>Latitude : <span id="Lati"></span> </p>
    <p>Longitude : <span id="Long"></span></p>


    <script>
    (function () {
      
        document.getElementById("uploadFile").onchange = function(el) {
            readURL(this)
                EXIF.getData(el.target.files[0], function() {
                 
                   EXIF.getData(this,()=>{
                    if(Object.keys(this.exifdata).length > 0){
                    generate_lat_lang(this)
              
                }else{
                      document.getElementById("Lati").innerText = "N/A"
                     document.getElementById("Long").innerText = "N/A"
                      alert("No GPS Data Available")
                    }
   
                    });
    
                });
            }
            var image = document.getElementsByClassName('DisplayImage');
        for (var i = 0; i < image.length; i++) {
            image[i].addEventListener('click', function(){
                EXIF.getData(this,()=>{
            if(Object.keys(this.exifdata).length > 0){
                generate_lat_lang(this)
            }else{
              document.getElementById("Lati").innerText = "N/A"
              document.getElementById("Long").innerText = "N/A"
               alert("No GPS Data Available")
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