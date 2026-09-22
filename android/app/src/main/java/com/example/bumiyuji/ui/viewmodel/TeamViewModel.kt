package com.example.bumiyuji.ui.viewmodel

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.bumiyuji.data.api.TeamProfileDto
import com.example.bumiyuji.data.repository.TeamRepository
import com.example.bumiyuji.ui.UiState
import kotlinx.coroutines.launch
import okhttp3.MultipartBody
import okhttp3.RequestBody

class TeamViewModel(private val repository: TeamRepository) : ViewModel() {

    var uiState by mutableStateOf<UiState<List<TeamProfileDto>>>(UiState.Idle)
    var detailUiState by mutableStateOf<UiState<TeamProfileDto>>(UiState.Idle)

    fun fetchTeamProfiles() {
        viewModelScope.launch {
            uiState = UiState.Loading
            val result = repository.getAdminTeamProfiles()
            uiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow())
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Failed to fetch team profiles")
            }
        }
    }

    fun fetchDetail(id: Int) {
        viewModelScope.launch {
            detailUiState = UiState.Loading
            val result = repository.getAdminTeamProfileDetail(id)
            detailUiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow())
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Failed to fetch team detail")
            }
        }
    }

    fun createTeamProfile(
        name: RequestBody,
        position: RequestBody?,
        instagram: RequestBody?,
        linkedin: RequestBody?,
        image: MultipartBody.Part?,
        isPublished: RequestBody?,
        sortOrder: RequestBody?
    ) {
        viewModelScope.launch {
            uiState = UiState.Loading
            val result = repository.createTeamProfile(name, position, instagram, linkedin, image, isPublished, sortOrder)
            if (result.isSuccess) {
                fetchTeamProfiles()
            } else {
                uiState = UiState.Error(result.exceptionOrNull()?.message ?: "Create team profile failed")
            }
        }
    }

    fun updateTeamProfile(
        id: Int,
        name: RequestBody,
        position: RequestBody?,
        instagram: RequestBody?,
        linkedin: RequestBody?,
        image: MultipartBody.Part?,
        isPublished: RequestBody?,
        sortOrder: RequestBody?
    ) {
        viewModelScope.launch {
            detailUiState = UiState.Loading
            val result = repository.updateTeamProfile(id, name, position, instagram, linkedin, image, isPublished, sortOrder)
            if (result.isSuccess) {
                fetchTeamProfiles()
                detailUiState = UiState.Success(result.getOrThrow())
            } else {
                detailUiState = UiState.Error(result.exceptionOrNull()?.message ?: "Update team profile failed")
            }
        }
    }

    fun deleteTeamProfile(id: Int) {
        viewModelScope.launch {
            val result = repository.deleteTeamProfile(id)
            if (result.isSuccess) {
                fetchTeamProfiles()
            }
        }
    }
}
