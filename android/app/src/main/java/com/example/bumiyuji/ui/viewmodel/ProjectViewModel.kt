package com.example.bumiyuji.ui.viewmodel

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.bumiyuji.data.api.ProjectDto
import com.example.bumiyuji.data.api.ProjectStageDto
import com.example.bumiyuji.data.repository.ProjectRepository
import com.example.bumiyuji.ui.UiState
import kotlinx.coroutines.launch
import okhttp3.MultipartBody
import okhttp3.RequestBody

class ProjectViewModel(private val repository: ProjectRepository) : ViewModel() {

    var projectsUiState by mutableStateOf<UiState<List<ProjectDto>>>(UiState.Idle)
    var detailUiState by mutableStateOf<UiState<ProjectDto>>(UiState.Idle)
    var stagesUiState by mutableStateOf<UiState<List<ProjectStageDto>>>(UiState.Idle)

    fun fetchProjects() {
        viewModelScope.launch {
            projectsUiState = UiState.Loading
            val result = repository.getProjects()
            projectsUiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow().data)
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Failed to fetch projects")
            }
        }
    }

    fun fetchDetail(id: Int) {
        viewModelScope.launch {
            detailUiState = UiState.Loading
            val result = repository.getProjectDetail(id)
            detailUiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow())
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Failed to fetch project detail")
            }
        }
    }

    fun createProject(
        name: String,
        client: String,
        location: String?,
        category: String?,
        startDate: String?,
        deadline: String?,
        status: String?,
        progress: Int?,
        description: String?,
        coverImage: MultipartBody.Part?
    ) {
        viewModelScope.launch {
            projectsUiState = UiState.Loading
            val nameBody = RequestBody.create(MultipartBody.FORM, name)
            val clientBody = RequestBody.create(MultipartBody.FORM, client)
            val locBody = location?.let { RequestBody.create(MultipartBody.FORM, it) }
            val catBody = category?.let { RequestBody.create(MultipartBody.FORM, it) }
            val startBody = startDate?.let { RequestBody.create(MultipartBody.FORM, it) }
            val deadBody = deadline?.let { RequestBody.create(MultipartBody.FORM, it) }
            val statusBody = status?.let { RequestBody.create(MultipartBody.FORM, it) }
            val progBody = progress?.let { RequestBody.create(MultipartBody.FORM, it.toString()) }
            val descBody = description?.let { RequestBody.create(MultipartBody.FORM, it) }

            val result = repository.createProject(
                nameBody, clientBody, locBody, catBody, startBody, deadBody, statusBody, progBody, descBody, coverImage
            )

            if (result.isSuccess) {
                fetchProjects()
            } else {
                projectsUiState = UiState.Error(result.exceptionOrNull()?.message ?: "Failed to create project")
            }
        }
    }

    fun updateProject(
        id: Int,
        name: String,
        client: String,
        location: String?,
        category: String?,
        startDate: String?,
        deadline: String?,
        status: String?,
        progress: Int?,
        description: String?,
        coverImage: MultipartBody.Part?
    ) {
        viewModelScope.launch {
            detailUiState = UiState.Loading
            val nameBody = RequestBody.create(MultipartBody.FORM, name)
            val clientBody = RequestBody.create(MultipartBody.FORM, client)
            val locBody = location?.let { RequestBody.create(MultipartBody.FORM, it) }
            val catBody = category?.let { RequestBody.create(MultipartBody.FORM, it) }
            val startBody = startDate?.let { RequestBody.create(MultipartBody.FORM, it) }
            val deadBody = deadline?.let { RequestBody.create(MultipartBody.FORM, it) }
            val statusBody = status?.let { RequestBody.create(MultipartBody.FORM, it) }
            val progBody = progress?.let { RequestBody.create(MultipartBody.FORM, it.toString()) }
            val descBody = description?.let { RequestBody.create(MultipartBody.FORM, it) }

            val result = repository.updateProject(
                id, nameBody, clientBody, locBody, catBody, startBody, deadBody, statusBody, progBody, descBody, coverImage
            )

            if (result.isSuccess) {
                fetchDetail(id)
            } else {
                detailUiState = UiState.Error(result.exceptionOrNull()?.message ?: "Failed to update project")
            }
        }
    }

    fun deleteProject(id: Int) {
        viewModelScope.launch {
            val result = repository.deleteProject(id)
            if (result.isSuccess) {
                fetchProjects()
            }
        }
    }

    fun fetchStages(projectId: Int) {
        viewModelScope.launch {
            stagesUiState = UiState.Loading
            val result = repository.getStages(projectId)
            stagesUiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow())
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Failed to fetch stages")
            }
        }
    }

    fun createStage(projectId: Int, data: Map<String, String>) {
        viewModelScope.launch {
            val result = repository.createStage(projectId, data)
            if (result.isSuccess) {
                fetchDetail(projectId)
            }
        }
    }

    fun updateStage(projectId: Int, stageId: Int, data: Map<String, String>) {
        viewModelScope.launch {
            val result = repository.updateStage(projectId, stageId, data)
            if (result.isSuccess) {
                fetchDetail(projectId)
            }
        }
    }

    fun deleteStage(projectId: Int, stageId: Int) {
        viewModelScope.launch {
            val result = repository.deleteStage(projectId, stageId)
            if (result.isSuccess) {
                fetchDetail(projectId)
            }
        }
    }
}
