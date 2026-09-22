package com.example.bumiyuji.data.repository

import com.example.bumiyuji.data.api.*
import okhttp3.MultipartBody
import okhttp3.RequestBody
import retrofit2.Response

class ProjectRepository(private val apiService: ApiService) {

    suspend fun getProjects(page: Int? = null): Result<PaginatedData<ProjectDto>> {
        return handleApi { apiService.getAdminProjects(page) }
    }

    suspend fun getProjectDetail(id: Int): Result<ProjectDto> {
        return handleApi { apiService.getAdminProjectDetail(id) }
    }

    suspend fun createProject(
        name: RequestBody,
        client: RequestBody,
        location: RequestBody?,
        category: RequestBody?,
        startDate: RequestBody?,
        deadline: RequestBody?,
        status: RequestBody?,
        progress: RequestBody?,
        description: RequestBody?,
        coverImage: MultipartBody.Part?
    ): Result<ProjectDto> {
        return handleApi {
            apiService.createProject(
                name, client, location, category, startDate, deadline, status, progress, description, coverImage
            )
        }
    }

    suspend fun updateProject(
        id: Int,
        name: RequestBody?,
        client: RequestBody?,
        location: RequestBody?,
        category: RequestBody?,
        startDate: RequestBody?,
        deadline: RequestBody?,
        status: RequestBody?,
        progress: RequestBody?,
        description: RequestBody?,
        coverImage: MultipartBody.Part?
    ): Result<ProjectDto> {
        return handleApi {
            apiService.updateProject(
                id, name, client, location, category, startDate, deadline, status, progress, description, coverImage
            )
        }
    }

    suspend fun deleteProject(id: Int): Result<Unit> {
        return handleApi { apiService.deleteProject(id) }
    }

    suspend fun getStages(projectId: Int): Result<List<ProjectStageDto>> {
        return handleApi { apiService.getProjectStages(projectId) }
    }

    suspend fun createStage(projectId: Int, data: Map<String, String>): Result<ProjectStageDto> {
        return handleApi { apiService.createProjectStage(projectId, data) }
    }

    suspend fun updateStage(projectId: Int, stageId: Int, data: Map<String, String>): Result<ProjectStageDto> {
        return handleApi { apiService.updateProjectStage(projectId, stageId, data) }
    }

    suspend fun deleteStage(projectId: Int, stageId: Int): Result<Unit> {
        return handleApi { apiService.deleteProjectStage(projectId, stageId) }
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
