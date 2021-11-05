import { BaseGuard } from '../core/base.guard.js';
export class AdminGuard extends BaseGuard {

	/**
	 * @param {Request} request
	 * @returns {Promise<boolean>|boolean}
	 */
	canActivate(request) {
		return true;
	}
}