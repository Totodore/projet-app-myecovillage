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
		setInterval(() => this.fetchData(), 500);
  }

  async onInit() {
    setTimeout(() => this.barAnimation(), 2000);
    if (this.select(".no-data-link"))
      this.navigate("minigame", ".no-data-link");
    this.googleApi();
  }

	async fetchData() {
		const res = await this.apiService.get("/" + baseUrl + "/api/data/micro", false);
		this.log("Micro value", res);
		this.select("#bruit-value").innerHTML = res.mic;
		this.select("#bruit-progress").setAttribute("stroke-dasharray", `${res.mic / 80 * 100}, 100`);
	}

  googleApi() {
    const locations = [
      ["Ecoquartier 14e", 48.832341, 2.326305, 4],
      ["Ecoquartier 5e", 48.842764, 2.357118, 5],
      ["Ecoquartier 12e", 48.835307, 2.382825, 3],
    ];

		const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 13,
      center: new google.maps.LatLng(48.83, 2.32),
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
      const n = +compteur.dataset.value;
      const duree = 1;
      const delta = Math.ceil((duree * 1000) / n);

			if (n == 0)
				continue;

      function countdown() {
        compteur.innerHTML = ++cpt + "%";
        if (cpt < n) {
          setTimeout(countdown, delta);
        }
      }
      countdown();
			compteur.parentElement.parentElement.style.maxHeight = n + "%";
			compteur.style.opacity = 1;
    }
  }
}
