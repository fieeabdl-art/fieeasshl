package com.example.bumiyuji.data.repository

import com.example.bumiyuji.data.api.ApiService
import com.example.bumiyuji.data.api.HeroSlideDto
import com.example.bumiyuji.data.api.ApiResponse
import okhttp3.MultipartBody
import retrofit2.Response

class HeroRepository(private val apiService: ApiService) {

    suspend fun getAdminHeroSlides(): Result<List<HeroSlideDto>> {
        return handleApi { apiService.getAdminHeroSlides() }
    }

    suspend fun uploadHeroSlides(images: List<MultipartBody.Part>): Result<List<HeroSlideDto>> {
        return handleApi { apiService.createHeroSlides(images) }
    }

    suspend fun deleteHeroSlide(id: Int): Result<Unit> {
        return handleApi { apiService.deleteHeroSlide(id) }
    }

    suspend fun reorderHeroSlides(order: List<Int>): Result<Unit> {
        return handleApi { apiService.reorder(mapOf("order" to order)) }
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
