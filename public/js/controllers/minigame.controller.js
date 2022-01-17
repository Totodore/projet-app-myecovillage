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

    async onInit() {}
}