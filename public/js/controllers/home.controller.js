import { BaseController } from "../core/base.controller.js";
import { ApiService } from "../services/api.service.js";

export class HomeController extends BaseController {
  id = "home";

  /**
   * @param {ApiService} apiService
   */
  constructor(params, apiService) {
    super("home", params);
    this.apiService = apiService;
  }

  async onInit() {
    setTimeout(() => this.barAnimation(), 2000);
    if (this.select(".no-data-link"))
      this.navigate("minigame", ".no-data-link");
    this.googleApi();
  }

  googleApi() {
    const locations = [
      ["Bondi Beach", -33.890542, 151.274856, 4],
      ["Coogee Beach", -33.923036, 151.259052, 5],
      ["Cronulla Beach", -34.028249, 151.157507, 3],
      ["Manly Beach", -33.80010128657071, 151.28747820854187, 2],
      ["Maroubra Beach", -33.950198, 151.259302, 1],
    ];

		const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
    });

    const infowindow = new google.maps.InfoWindow();

    let marker, i;

    for (i = 0; i < locations.length; i++) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
      });

      google.maps.event.addListener(
        marker,
        "click",
        (function (marker, i) {
          return function () {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
          };
        })(marker, i)
      );
    }
  }
  barAnimation() {
    const compteurs = this.selectAll(".compteur");
    for (let compteur of compteurs) {
      let cpt = 0;
      const n = +compteur.getAttribute("data-value");
      const duree = 2;
      const delta = Math.ceil((duree * 1000) / n);

      function countdown() {
        compteur.innerHTML = ++cpt + "%";
        if (cpt < n) {
          setTimeout(countdown, delta);
        }
      }
      countdown();
    }
  }
}
