package com.example.bumiyuji.data.repository

import com.example.bumiyuji.data.api.ApiService
import com.example.bumiyuji.data.api.SettingDto
import com.example.bumiyuji.data.api.ApiResponse
import okhttp3.MultipartBody
import okhttp3.RequestBody
import retrofit2.Response

class SettingRepository(private val apiService: ApiService) {

    suspend fun getAdminSettings(): Result<SettingDto> {
        return handleApi { apiService.getAdminSettings() }
    }

    suspend fun updateSettings(
        data: Map<String, RequestBody>,
        images: List<MultipartBody.Part>
    ): Result<SettingDto> {
        return handleApi { apiService.updateSettings(data, images) }
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
