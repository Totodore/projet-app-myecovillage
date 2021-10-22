import { BaseGuard } from '../core/base.guard.js';
export class AdminGuard extends BaseGuard {
	canActivate(request) {
		return true;
	}
}