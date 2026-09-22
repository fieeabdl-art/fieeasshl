package com.example.bumiyuji.ui.viewmodel

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.bumiyuji.data.api.HeroSlideDto
import com.example.bumiyuji.data.repository.HeroRepository
import com.example.bumiyuji.ui.UiState
import kotlinx.coroutines.launch
import okhttp3.MultipartBody

class HeroViewModel(private val repository: HeroRepository) : ViewModel() {

    var uiState by mutableStateOf<UiState<List<HeroSlideDto>>>(UiState.Idle)

    fun fetchHeroSlides() {
        viewModelScope.launch {
            uiState = UiState.Loading
            val result = repository.getAdminHeroSlides()
            uiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow())
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Failed to fetch hero slides")
            }
        }
    }

    fun uploadImages(images: List<MultipartBody.Part>) {
        viewModelScope.launch {
            uiState = UiState.Loading
            val result = repository.uploadHeroSlides(images)
            if (result.isSuccess) {
                fetchHeroSlides()
            } else {
                uiState = UiState.Error(result.exceptionOrNull()?.message ?: "Upload failed")
            }
        }
    }

    fun deleteSlide(id: Int) {
        viewModelScope.launch {
            val result = repository.deleteHeroSlide(id)
            if (result.isSuccess) {
                fetchHeroSlides()
            }
        }
    }

    fun reorderSlides(order: List<Int>) {
        viewModelScope.launch {
            val result = repository.reorderHeroSlides(order)
            if (result.isSuccess) {
                fetchHeroSlides()
            }
        }
    }
}
