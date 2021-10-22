import { BaseGuard } from "../core/base.guard";
import { ApiService } from "../services/api.service";

export class AuthGuard extends BaseGuard {
	canActivate(request) {
		/**
		 * @type {ApiService}
		 */
		const api = this.services[ApiService];
	}
}