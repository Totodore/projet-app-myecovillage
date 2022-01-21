import { BaseController } from "../core/base.controller.js";
import { ApiService } from "../services/api.service.js";

export class MinigameController extends BaseController {
  id = "minigame";

  data = {};
  wantedKeys = [
		"daymood",
    "breathing",
    "daysleep",
    "interactiveday",
    "sport",
    "noisedaymood",
    "noisenightmood",
    "wentoutside",
  ];
  sportKeys = ["sportduration", "sportharder", "sportindoor"];
  /**
   * @param {ApiService} apiService
   */
  constructor(params, apiService) {
    super("minigame", params);
    this.apiService = apiService;
		this.data = {
			daymood: 2,
			noisenightmood: 2,
			noisedaymood: 2,
		};
  }

  async onInit() {
    this.select("#breathing").addEventListener("input", (e) =>
      this.rangeSlide(e.target.value)
    );
    this.select("#Sleep").addEventListener("input", (e) =>
      this.rangeslidesleep(e.target.value)
    );
    this.select("#Inter").addEventListener("input", (e) =>
      this.rangeslidesinter(e.target.value)
    );
    this.selectAll("input[name=sport]").forEach((el) =>
      el.addEventListener(
        "change",
        (e) =>
          (this.select(".sport-wrapper").style.display =
            e.target.value == "on" ? "block" : "none")
      )
    );
    this.selectAll(".empsmiley > *").forEach((el) =>
      el.addEventListener("click", () => this.selectHappiness(el))
    );
    this.selectAll(".soundicon > *").forEach((el) =>
      el.addEventListener("click", () => this.selectSound(el))
    );
    this.selectAll(".Qwent > *").forEach((el) =>
      el.addEventListener("click", () => this.selectIconOutside(el))
    );
    this.selectAll(".Qsport > *").forEach((el) =>
      el.addEventListener("click", () => this.selectIconOutside(el))
    );
    this.select("form").addEventListener("submit", (e) => this.onSubmit(e));
  }

  /**
   * Sliders animations
   */
  rangeSlide(value) {
    this.select("#rangeValue").innerHTML = value + " %";
  }
  rangeslidesleep(value) {
    this.select("#rangevaluesleep").innerHTML =
      value + (value == 0 ? " Heure" : " Heures");
  }
  rangeslidesinter(value) {
    this.select("#rangevaluesinter").innerHTML =
      value + (value == 0 ? " Intéraction" : " Interactions");
  }

  /**
   * @param {HTMLElement} el
   */
  selectHappiness(el) {
    el.parentElement
      .querySelector(".smiley-selected")
      .classList.remove("smiley-selected");
    el.classList.add("smiley-selected");
		this.data.daymood = +el.dataset.value;
  }

  /**
   * @param {HTMLElement} el
   */
  selectSound(el) {
    if (el.parentElement.querySelector(".sound-selected"))
      el.parentElement
        .querySelector(".sound-selected")
        .classList.remove("sound-selected");
    el.classList.add("sound-selected");
		this.data[el.parentElement.dataset.key] = +el.dataset.value;
  }

  /**
   * @param {HTMLElement} el
   */
  selectIconOutside(el) {
    if (el.parentElement.querySelector(".selected-icon"))
      el.parentElement
        .querySelector(".selected-icon")
        .classList.remove("selected-icon");
    el.classList.add("selected-icon");
		this.data[el.parentElement.dataset.key] = el.dataset.value;
  }

  /**
   * @param {Event} e
   */
  async onSubmit(e) {
    e.preventDefault();
    const form = e.target;
    this.data = {...Object.fromEntries(new FormData(form).entries()), ...this.data };
		for (const key in this.data) {
			if (this.data[key] === "on")
				this.data[key] = true;
			else if (this.data[key] === "off")
				this.data[key] = false;
			else if (typeof this.data[key] === 'string' && !isNaN(+this.data[key]))
				this.data[key] = +this.data[key];
			if (!this.data.sport && this.sportKeys.includes(key))
				delete this.data[key];
		}
		if (!this.wantedKeys.reduce((acc, cur) => acc && this.data[cur] !== undefined, true)) {
			console.error("Missing data", this.data);
			return;
		}

		try {
			const res = await this.apiService.post("/api/minigame", this.data)
			this.navigate("");
		} catch(e) {
			console.error(e);
		}
  }
}
