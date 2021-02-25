beaconCircle = function(scene,c) {

    


    var geometry = new THREE.CylinderGeometry(2, 2, 1, 32);
    
    var material = new THREE.MeshLambertMaterial({ color: c });

    var floor = new THREE.Mesh(geometry, material);

    scene.add(floor);

    return floor;
}