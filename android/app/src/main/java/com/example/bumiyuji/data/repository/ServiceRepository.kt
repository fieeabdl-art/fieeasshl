package com.example.bumiyuji.data.repository

import com.example.bumiyuji.data.api.ApiService
import com.example.bumiyuji.data.api.ServiceDto
import com.example.bumiyuji.data.api.ApiResponse
import okhttp3.MultipartBody
import okhttp3.RequestBody
import retrofit2.Response

class ServiceRepository(private val apiService: ApiService) {

    suspend fun getAdminServices(): Result<List<ServiceDto>> {
        return handleApi { apiService.getAdminServices() }
    }

    suspend fun getServiceDetail(id: Int): Result<ServiceDto> {
        return handleApi { apiService.getAdminServiceDetail(id) }
    }

    suspend fun createService(
        title: RequestBody,
        description: RequestBody,
        image: MultipartBody.Part?,
        status: RequestBody?,
        sortOrder: RequestBody?
    ): Result<ServiceDto> {
        return handleApi { apiService.createService(title, description, image, status, sortOrder) }
    }

    suspend fun updateService(
        id: Int,
        title: RequestBody,
        description: RequestBody,
        image: MultipartBody.Part?,
        status: RequestBody?,
        sortOrder: RequestBody?
    ): Result<ServiceDto> {
        return handleApi { apiService.updateService(id, title, description, image, status, sortOrder) }
    }

    suspend fun deleteService(id: Int): Result<Unit> {
        return handleApi { apiService.deleteService(id) }
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
