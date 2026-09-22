package com.example.bumiyuji.data.repository

import com.example.bumiyuji.data.api.ApiService
import com.example.bumiyuji.data.api.TeamProfileDto
import com.example.bumiyuji.data.api.ApiResponse
import okhttp3.MultipartBody
import okhttp3.RequestBody
import retrofit2.Response

class TeamRepository(private val apiService: ApiService) {

    suspend fun getAdminTeamProfiles(): Result<List<TeamProfileDto>> {
        return handleApi { apiService.getAdminTeamProfiles() }
    }

    suspend fun getAdminTeamProfileDetail(id: Int): Result<TeamProfileDto> {
        return handleApi { apiService.getAdminTeamProfileDetail(id) }
    }

    suspend fun createTeamProfile(
        name: RequestBody,
        position: RequestBody?,
        instagram: RequestBody?,
        linkedin: RequestBody?,
        image: MultipartBody.Part?,
        isPublished: RequestBody?,
        sortOrder: RequestBody?
    ): Result<TeamProfileDto> {
        return handleApi {
            apiService.createTeamProfile(
                name, position, instagram, linkedin, image, isPublished, sortOrder
            )
        }
    }

    suspend fun updateTeamProfile(
        id: Int,
        name: RequestBody?,
        position: RequestBody?,
        instagram: RequestBody?,
        linkedin: RequestBody?,
        image: MultipartBody.Part?,
        isPublished: RequestBody?,
        sortOrder: RequestBody?
    ): Result<TeamProfileDto> {
        return handleApi {
            apiService.updateTeamProfile(
                id = id,
                name = name,
                position = position,
                instagram = instagram,
                linkedin = linkedin,
                image = image,
                isPublished = isPublished,
                sortOrder = sortOrder
            )
        }
    }

    suspend fun deleteTeamProfile(id: Int): Result<Unit> {
        return handleApi { apiService.deleteTeamProfile(id) }
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
