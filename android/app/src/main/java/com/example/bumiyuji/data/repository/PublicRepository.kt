package com.example.bumiyuji.data.repository

import com.example.bumiyuji.data.api.*
import retrofit2.Response

class PublicRepository(private val apiService: ApiService) {

    suspend fun getInitData(): Result<InitDataResponse> {
        return handleApi { apiService.getInitData() }
    }

    suspend fun getPortfolios(category: String? = null): Result<PaginatedData<PortfolioDto>> {
        return handleApi { apiService.getPublicPortfolios(category = category) }
    }

    suspend fun getServices(): Result<List<ServiceDto>> {
        return handleApi { apiService.getPublicServices() }
    }

    suspend fun getTeam(): Result<List<TeamProfileDto>> {
        return handleApi { apiService.getPublicTeam() }
    }

    suspend fun getFaqs(): Result<List<FaqDto>> {
        return handleApi { apiService.getPublicFaqs() }
    }

    private suspend fun <T> handleApi(call: suspend () -> Response<ApiResponse<T>>): Result<T> {
        return try {
            val response = call()
            if (response.isSuccessful && response.body() != null) {
                Result.success(response.body()!!.data)
            } else {
                Result.failure(Exception(response.errorBody()?.string() ?: "API Error"))
            }
        } catch (e: Exception) {
            Result.failure(e)
        }
    }
}
