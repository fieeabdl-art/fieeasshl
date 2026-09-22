package com.example.bumiyuji.ui.viewmodel

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.bumiyuji.data.api.InitDataResponse
import com.example.bumiyuji.data.repository.PublicRepository
import com.example.bumiyuji.ui.UiState
import kotlinx.coroutines.launch

class HomeViewModel(private val repository: PublicRepository) : ViewModel() {

    var uiState by mutableStateOf<UiState<InitDataResponse>>(UiState.Idle)

    fun fetchInitData() {
        viewModelScope.launch {
            uiState = UiState.Loading
            val result = repository.getInitData()
            uiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow())
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Failed to load data")
            }
        }
    }
}
