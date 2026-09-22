package com.example.bumiyuji.data.repository

import com.example.bumiyuji.data.api.ApiService
import com.example.bumiyuji.data.api.PortfolioDetailDto
import com.example.bumiyuji.data.api.PortfolioDto
import com.example.bumiyuji.data.api.PaginatedData
import okhttp3.MultipartBody
import okhttp3.RequestBody
import retrofit2.Response

class PortfolioRepository(private val apiService: ApiService) {

    suspend fun getPublicPortfolios(page: Int? = null, category: String? = null): Result<PaginatedData<PortfolioDto>> {
        return handleApi { apiService.getPublicPortfolios(page = page, category = category) }
    }

    suspend fun getPortfolioDetail(slug: String): Result<PortfolioDetailDto> {
        return handleApi { apiService.getPublicPortfolioDetail(slug) }
    }

    suspend fun getAdminPortfolios(page: Int? = null): Result<PaginatedData<PortfolioDto>> {
        return handleApi { apiService.getAdminPortfolios(page) }
    }

    suspend fun getAdminPortfolioDetail(id: Int): Result<PortfolioDetailDto> {
        return handleApi { apiService.getAdminPortfolioDetail(id) }
    }

    suspend fun createPortfolio(
        title: RequestBody,
        category: RequestBody,
        description: RequestBody?,
        image: MultipartBody.Part?,
        isPublished: RequestBody?,
        sortOrder: RequestBody?
    ): Result<PortfolioDetailDto> {
        return handleApi { apiService.createPortfolio(title, category, description, image, isPublished, sortOrder) }
    }

    suspend fun updatePortfolio(
        id: Int,
        title: RequestBody?,
        category: RequestBody?,
        description: RequestBody?,
        image: MultipartBody.Part?,
        isPublished: RequestBody?,
        sortOrder: RequestBody?
    ): Result<PortfolioDetailDto> {
        return handleApi { apiService.updatePortfolio(id, title, category, description, image, isPublished = isPublished, sortOrder = sortOrder) }
    }

    suspend fun deletePortfolio(id: Int): Result<Unit> {
        return handleApi { apiService.deletePortfolio(id) }
    }

    suspend fun getPortfolioPhases(portfolioId: Int): Result<List<com.example.bumiyuji.data.api.PortfolioPhaseDto>> {
        return handleApi { apiService.getPortfolioPhases(portfolioId) }
    }

    suspend fun updatePortfolioPhase(portfolioId: Int, phaseId: Int, title: String, description: String?): Result<com.example.bumiyuji.data.api.PortfolioPhaseDto> {
        return handleApi { apiService.updatePortfolioPhase(portfolioId, phaseId, title, description) }
    }

    suspend fun uploadPhaseImages(portfolioId: Int, phaseId: Int, images: List<MultipartBody.Part>): Result<PortfolioDetailDto> {
        return handleApi { apiService.uploadPhaseImages(portfolioId, phaseId, images) }
    }

    suspend fun deletePhaseImage(portfolioId: Int, phaseId: Int, imageId: Int): Result<Unit> {
        return handleApi { apiService.deletePhaseImage(portfolioId, phaseId, imageId) }
    }

    private suspend fun <T> handleApi(call: suspend () -> Response<com.example.bumiyuji.data.api.ApiResponse<T>>): Result<T> {
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
