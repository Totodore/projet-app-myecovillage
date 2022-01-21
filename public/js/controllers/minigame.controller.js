import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class MinigameController extends BaseController {

    id = "minigame";

    /**
     * @param {ApiService} apiService
     */
    constructor(params, apiService) {
        super("minigame", params);
        this.apiService = apiService;
    }
    rangeSlide(value) {
        this.select('#rangeValue').innerHTML = value + "%";
    }
    rangeslidesleep(value) {
        this.select('#rangevaluesleep').innerHTML = value + "Heure";
    }
    async onInit() {
        this.select("#breathing").addEventListener("input", e => this.rangeSlide(e.target.value));
        this.select("#Sleep").addEventListener("input", e => this.rangeSlide(e.target.value));

    }
}