package com.example.bumiyuji.data.api

data class LoginRequest(
    val email: String,
    val password: String,
    val device_name: String
)

data class LoginResponse(
    val token: String,
    val admin: AdminDto
)

data class AdminDto(
    val id: Int,
    val name: String,
    val email: String,
    val role: String
)

data class SettingDto(
    val site_name: String?,
    val logo_url: String?,
    val favicon_url: String?,
    val hero: HeroSectionDto?,
    val about: AboutSectionDto?,
    val corporate: CorporateSectionDto?,
    val contact: ContactSectionDto?,
    val appointment: AppointmentSectionDto?
)

data class HeroSectionDto(
    val title: String?,
    val subtitle: String?,
    val image_url: String?
)

data class AboutSectionDto(
    val title: String?,
    val description: String?,
    val vision: String?,
    val mission: String?,
    val image_url: String?,
    val video_url: String?
)

data class CorporateSectionDto(
    val parent_company_name: String?,
    val parent_company_brand: String?,
    val ecosystem_intro: String?,
    val parent_company_logo_url: String?
)

data class ContactSectionDto(
    val whatsapp: String?,
    val email: String?,
    val address: String?,
    val address_note: String?,
    val secondary_address: String?,
    val secondary_address_note: String?,
    val office_hours: String?,
    val maps_url: String?,
    val social_links: Map<String, String>?
)

data class AppointmentSectionDto(
    val whatsapp_number: String?,
    val message_template: String?
)

data class HeroSlideDto(
    val id: Int,
    val image_url: String?,
    val sort_order: Int
)

data class PortfolioDto(
    val id: Int,
    val title: String,
    val slug: String,
    val category: String,
    val category_label: String,
    val image_url: String?,
    val short_description: String?
)

data class PortfolioDetailDto(
    val id: Int,
    val title: String,
    val slug: String,
    val category: String,
    val category_label: String,
    val description: String?,
    val image_url: String?,
    val phases: List<PortfolioPhaseDto>?
)

data class PortfolioPhaseDto(
    val id: Int,
    val title: String,
    val description: String?,
    val percentage: Int,
    val sort_order: Int,
    val images: List<PortfolioPhaseImageDto>?
)

data class PortfolioPhaseImageDto(
    val id: Int,
    val image_url: String?,
    val sort_order: Int
)

data class ServiceDto(
    val id: Int,
    val title: String,
    val slug: String,
    val description: String?,
    val image_url: String?,
    val sort_order: Int
)

data class TeamProfileDto(
    val id: Int,
    val name: String,
    val position: String?,
    val image_url: String?,
    val instagram: String?,
    val linkedin: String?,
    val sort_order: Int
)

data class FaqDto(
    val id: Int,
    val question: String,
    val answer: String,
    val sort_order: Int
)

data class AffiliatedDivisionDto(
    val id: Int,
    val initial: String,
    val color: String,
    val logo_url: String?,
    val name: String,
    val description: String?,
    val sort_order: Int
)

data class ProjectDto(
    val id: Int,
    val name: String,
    val client: String,
    val location: String?,
    val category: String?,
    val start_date: String?,
    val deadline: String?,
    val status: String,
    val progress: Int,
    val description: String?,
    val cover_image: String?,
    val stages: List<ProjectStageDto>?,
    val created_at: String?,
    val updated_at: String?
)

data class ProjectStageDto(
    val id: Int,
    val project_id: Int,
    val name: String,
    val status: String,
    val sort_order: Int,
    val start_date: String?,
    val end_date: String?,
    val description: String?,
    val created_at: String?,
    val updated_at: String?
)
