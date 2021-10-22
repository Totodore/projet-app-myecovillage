export class BaseGuard {
	constructor(services) {
		this.services = services;
	}

	/**
	 * @param {Request} request
	 * @returns {Promise<boolean>|boolean}
	 */
	canActivate(request) {
		return true;
	}
}