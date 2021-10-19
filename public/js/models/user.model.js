import { BaseModel } from "../core/base.model"
/**
 * Model for the users table
 */
export class UserModel extends BaseModel {

	/**
	 * @type {int}
	 */
	m_id;
	/**
	 * @type {string}
	 */
	m_username;

	/**
	 * @type {string}
	 */
	m_password;

	/**
	 * @type {string}
	 */
	m_email;

	/**
	 * @type {boolean} 
	 */
	m_isAdmin = false;
}
