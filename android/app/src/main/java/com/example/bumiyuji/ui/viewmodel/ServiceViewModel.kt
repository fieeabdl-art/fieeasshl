package com.example.bumiyuji.ui.viewmodel

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.bumiyuji.data.api.ServiceDto
import com.example.bumiyuji.data.repository.ServiceRepository
import com.example.bumiyuji.ui.UiState
import kotlinx.coroutines.launch
import okhttp3.MultipartBody
import okhttp3.RequestBody

class ServiceViewModel(private val repository: ServiceRepository) : ViewModel() {

    var uiState by mutableStateOf<UiState<List<ServiceDto>>>(UiState.Idle)
    var detailUiState by mutableStateOf<UiState<ServiceDto>>(UiState.Idle)

    fun fetchServices() {
        viewModelScope.launch {
            uiState = UiState.Loading
            val result = repository.getAdminServices()
            uiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow())
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Failed to fetch services")
            }
        }
    }

    fun fetchDetail(id: Int) {
        viewModelScope.launch {
            detailUiState = UiState.Loading
            val result = repository.getServiceDetail(id)
            detailUiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow())
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Failed to fetch service detail")
            }
        }
    }

    fun createService(
        title: RequestBody,
        description: RequestBody,
        image: MultipartBody.Part?,
        status: RequestBody?,
        sortOrder: RequestBody?
    ) {
        viewModelScope.launch {
            uiState = UiState.Loading
            val result = repository.createService(title, description, image, status, sortOrder)
            if (result.isSuccess) {
                fetchServices()
            } else {
                uiState = UiState.Error(result.exceptionOrNull()?.message ?: "Create service failed")
            }
        }
    }

    fun updateService(
        id: Int,
        title: RequestBody,
        description: RequestBody,
        image: MultipartBody.Part?,
        status: RequestBody?,
        sortOrder: RequestBody?
    ) {
        viewModelScope.launch {
            detailUiState = UiState.Loading
            val result = repository.updateService(id, title, description, image, status, sortOrder)
            if (result.isSuccess) {
                fetchServices()
                detailUiState = UiState.Success(result.getOrThrow())
            } else {
                detailUiState = UiState.Error(result.exceptionOrNull()?.message ?: "Update service failed")
            }
        }
    }

    fun deleteService(id: Int) {
        viewModelScope.launch {
            val result = repository.deleteService(id)
            if (result.isSuccess) {
                fetchServices()
            }
        }
    }
}
