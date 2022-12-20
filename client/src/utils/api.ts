import axios from "axios";

export const $axios = axios.create({
  baseURL: `${process.env.API_BASE_URL}`,
  headers: { 'Content-Type': 'application/json' },
  responseType: 'json',
});
