import { $axios } from "../../utils/api";

const BASE_URL = process.env.API_BASE_URL;

export const fetchRankingList = async (type, page, limit) => {
  const response = await $axios.post(`${BASE_URL}questionnaires/ranking`, {
    type: type,
    page: page,
    limit: limit
  });
  return response;
}

export const fetchHealth = async () => {
  const response = await $axios.get(`http://nginx:80/api/health`);
  return response;
}