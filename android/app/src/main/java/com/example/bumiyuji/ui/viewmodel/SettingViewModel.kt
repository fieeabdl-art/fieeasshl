package com.example.bumiyuji.ui.viewmodel

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.bumiyuji.data.api.SettingDto
import com.example.bumiyuji.data.repository.SettingRepository
import com.example.bumiyuji.ui.UiState
import kotlinx.coroutines.launch
import okhttp3.MultipartBody
import okhttp3.RequestBody

class SettingViewModel(private val repository: SettingRepository) : ViewModel() {

    var uiState by mutableStateOf<UiState<SettingDto>>(UiState.Idle)

    fun fetchSettings() {
        viewModelScope.launch {
            uiState = UiState.Loading
            val result = repository.getAdminSettings()
            uiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow())
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Failed to fetch settings")
            }
        }
    }

    fun updateSettings(data: Map<String, RequestBody>, images: List<MultipartBody.Part>) {
        viewModelScope.launch {
            uiState = UiState.Loading
            val result = repository.updateSettings(data, images)
            uiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow())
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Update settings failed")
            }
        }
    }
}
