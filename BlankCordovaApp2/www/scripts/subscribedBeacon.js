var subscribedBeacon  = function(name,major,minor,x,y,z)
{
    this.name = name;
    this.major = major;
    this.minor = minor;
    this.x = x;
    this.y = y;
    this.z = z;
   
    var isChange = 0;
    var distance = NaN;

   this.setDistance = function (distance)
    {
        this.distance = distance;
    }


   this.getDistance = function () {
       return this.distance;
   }
  
   
}