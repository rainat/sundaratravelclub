import { getCodeList, getNameList } from "country-list";
import axios from "axios"
// export const API_END_POINT = import.meta.env.DEV ? import.meta.env.VITE_API_END_POINT_DEV : import.meta.env.VITE_API_END_POINT\

export const API_END_POINT = import.meta.env.VITE_API_END_POINT
export const API_END_POINT_WP_JSON = API_END_POINT + 'wp-json/sundara/v1/'

export function ApiEndPointWith(namespace: string = '') {
	return API_END_POINT_WP_JSON + namespace
}

export function fetchAjaxWith(action: string) {
	let sundara = (window as any).sundara
	let formData = new FormData();
	formData.append('action', action);
	
	return fetch(sundara.ajaxurl, {
		method: 'POST',
		body: formData,
		credentials: 'include'
	}).then((res) => res.json())
}

export function fetchUpdateAjaxWith(action: string, body: any, file?: any) {
	let sundara = (window as any).sundara
	let formData = new FormData();
	
	formData.append('action', action);
	formData.append('updating', 'true');
	formData.append('data', JSON.stringify(body));
	formData.append('file', file.file);

	// return axios.post(sundara.ajaxurl, formData, {
	// 	withCredentials: true, headers: {
	// 		"Content-Type": "multipart/form-data",
	// 	}
	// })

	return fetch(sundara.ajaxurl, {
		method: 'POST',
		body: formData,
		credentials: 'include'
	})
}

export function fetchPostAjaxWith(action: string, body: any) {
	let sundara = (window as any).sundara
	let formData = new FormData();
	
	formData.append('action', action);
	formData.append('data', JSON.stringify(body));
	// formData.append('file',);

	return fetch(sundara.ajaxurl, {
		method: 'POST',
		body: formData,
		credentials: 'include'
	})
}

export function AllCountries() {
	return getCodeList()
}
