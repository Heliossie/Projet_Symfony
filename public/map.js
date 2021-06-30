let mymap = L.map('mapid').setView([43.61182309081874, 3.8720765279283667], 13);
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZ2FiYWdvb2wiLCJhIjoiY2twZTc0OTFwMXRsdjJ6b2d5NjRhaDllMyJ9.njhiqa0HxCPgZkTX0GV8FQ', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 15,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'your.mapbox.access.token'
}).addTo(mymap);




let geojson = [{
    "type": "FeatureCollection",
    "name": "VilleMTP_MTP_ParkingOuv",
    "crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84" } },
    "features": [
    { "type": "Feature", "properties": { "id": "34172_ARCTRI", "nom": "Arc de Triomphe", "insee": 34172, "adresse": "rue Foch", "url": null, "type_usage": "tous", "gratuit": "false", "nb_places": 451, "nb_pr": null, "nb_pmr": 10, "nb_voiture": 3, "nb_velo": 0, "nb_2r_el": null, "nb_autopar": null, "nb_2_rm": 0, "nb_covoit": null, "hauteur_ma": "190", "num_siret": "21340172202058", "Xlong": 3.87320075, "Ylat": 43.61100267, "tarif_pmr": null, "tarif_1h": null, "tarif_2h": null, "tarif_3h": null, "tarif_4h": null, "tarif_24h": null, "abo_reside": null, "abo_non_re": null, "type_ouvra": "ouvrage", "info": null, "typo_fonct": "Centre-ville", "domanialit": "Public", "proprietai": "Ville de Montpellier", "surf_utile": 9375, "nbre_niv": 5, "places_pub": 438, "places_res": 0 }, "geometry": { "type": "Point", "coordinates": [ 3.87320075, 43.611002669999898 ] } },

    ]
    }];

    L.geoJSON(geojson).addTo(mymap);

geojson.bindPopup("<b>" + geojson.nom + "</b>");