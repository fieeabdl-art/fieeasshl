package com.example.bumiyuji.ui.viewmodel

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.bumiyuji.data.api.PortfolioDetailDto
import com.example.bumiyuji.data.api.PortfolioDto
import com.example.bumiyuji.data.api.PortfolioPhaseDto
import com.example.bumiyuji.data.repository.PortfolioRepository
import com.example.bumiyuji.ui.UiState
import kotlinx.coroutines.launch
import okhttp3.MultipartBody
import okhttp3.RequestBody

class PortfolioViewModel(private val repository: PortfolioRepository) : ViewModel() {

    var portfoliosUiState by mutableStateOf<UiState<List<PortfolioDto>>>(UiState.Idle)
    var detailUiState by mutableStateOf<UiState<PortfolioDetailDto>>(UiState.Idle)
    var phaseUpdateUiState by mutableStateOf<UiState<Unit>>(UiState.Idle)

    fun fetchPortfolios() {
        viewModelScope.launch {
            portfoliosUiState = UiState.Loading
            val result = repository.getAdminPortfolios()
            portfoliosUiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow().data)
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Failed to fetch portfolios")
            }
        }
    }

    fun fetchDetail(id: Int) {
        viewModelScope.launch {
            detailUiState = UiState.Loading
            val result = repository.getAdminPortfolioDetail(id)
            detailUiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow())
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Failed to fetch detail")
            }
        }
    }

    fun deletePortfolio(id: Int) {
        viewModelScope.launch {
            val result = repository.deletePortfolio(id)
            if (result.isSuccess) {
                fetchPortfolios()
            }
        }
    }

    fun createPortfolio(
        title: String,
        category: String,
        description: String?,
        imagePart: MultipartBody.Part?,
        isPublished: Boolean = true,
        sortOrder: Int = 0
    ) {
        viewModelScope.launch {
            portfoliosUiState = UiState.Loading
            val titleBody = RequestBody.create(MultipartBody.FORM, title)
            val categoryBody = RequestBody.create(MultipartBody.FORM, category)
            val descBody = description?.let { RequestBody.create(MultipartBody.FORM, it) }
            val publishedBody = RequestBody.create(MultipartBody.FORM, if (isPublished) "1" else "0")
            val orderBody = RequestBody.create(MultipartBody.FORM, sortOrder.toString())

            val result = repository.createPortfolio(titleBody, categoryBody, descBody, imagePart, publishedBody, orderBody)
            if (result.isSuccess) {
                fetchPortfolios()
            } else {
                portfoliosUiState = UiState.Error(result.exceptionOrNull()?.message ?: "Failed to create portfolio")
            }
        }
    }

    fun updatePortfolio(
        id: Int,
        title: String,
        category: String,
        description: String?,
        imagePart: MultipartBody.Part?,
        isPublished: Boolean = true,
        sortOrder: Int = 0
    ) {
        viewModelScope.launch {
            detailUiState = UiState.Loading
            val titleBody = RequestBody.create(MultipartBody.FORM, title)
            val categoryBody = RequestBody.create(MultipartBody.FORM, category)
            val descBody = description?.let { RequestBody.create(MultipartBody.FORM, it) }
            val publishedBody = RequestBody.create(MultipartBody.FORM, if (isPublished) "1" else "0")
            val orderBody = RequestBody.create(MultipartBody.FORM, sortOrder.toString())

            val result = repository.updatePortfolio(id, titleBody, categoryBody, descBody, imagePart, publishedBody, orderBody)
            if (result.isSuccess) {
                fetchPortfolios()
                fetchDetail(id)
            } else {
                detailUiState = UiState.Error(result.exceptionOrNull()?.message ?: "Failed to update portfolio")
            }
        }
    }

    fun updatePhaseComplete(
        portfolioId: Int,
        phaseId: Int,
        title: String,
        description: String?,
        newImages: List<MultipartBody.Part>
    ) {
        viewModelScope.launch {
            phaseUpdateUiState = UiState.Loading

            // 1. Update Info
            val infoResult = repository.updatePortfolioPhase(portfolioId, phaseId, title, description)
            if (infoResult.isFailure) {
                phaseUpdateUiState = UiState.Error(infoResult.exceptionOrNull()?.message ?: "Failed to update phase info")
                return@launch
            }

            // 2. Upload Images if any
            if (newImages.isNotEmpty()) {
                val uploadResult = repository.uploadPhaseImages(portfolioId, phaseId, newImages)
                if (uploadResult.isFailure) {
                    phaseUpdateUiState = UiState.Error(uploadResult.exceptionOrNull()?.message ?: "Failed to upload images")
                    return@launch
                }
            }

            // Success
            phaseUpdateUiState = UiState.Success(Unit)
            fetchDetail(portfolioId)
        }
    }

    fun deletePhaseImage(portfolioId: Int, phaseId: Int, imageId: Int) {
        viewModelScope.launch {
            val result = repository.deletePhaseImage(portfolioId, phaseId, imageId)
            if (result.isSuccess) {
                fetchDetail(portfolioId)
            }
        }
    }
}
