package com.example.bumiyuji.data.api

data class ApiResponse<T>(
    val success: Boolean,
    val message: String,
    val data: T
)

data class PaginatedData<T>(
    val data: List<T>,
    val links: Map<String, String?>,
    val meta: PaginationMeta
)

data class PaginationMeta(
    val current_page: Int,
    val last_page: Int,
    val per_page: Int,
    val total: Int
)
