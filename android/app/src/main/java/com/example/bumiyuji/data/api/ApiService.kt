package com.example.bumiyuji.data.api

import okhttp3.MultipartBody
import okhttp3.RequestBody
import retrofit2.Response
import retrofit2.http.*

interface ApiService {

    // --- PUBLIC API ---

    @GET("public/init")
    suspend fun getInitData(): Response<ApiResponse<InitDataResponse>>

    @GET("public/portfolios")
    suspend fun getPublicPortfolios(
        @Query("page") page: Int? = null,
        @Query("category") category: String? = null,
        @Query("per_page") perPage: Int? = null
    ): Response<ApiResponse<PaginatedData<PortfolioDto>>>

    @GET("public/portfolios/{slug}")
    suspend fun getPublicPortfolioDetail(
        @Path("slug") slug: String
    ): Response<ApiResponse<PortfolioDetailDto>>

    @GET("public/services")
    suspend fun getPublicServices(): Response<ApiResponse<List<ServiceDto>>>

    @GET("public/team")
    suspend fun getPublicTeam(): Response<ApiResponse<List<TeamProfileDto>>>

    @GET("public/faq")
    suspend fun getPublicFaqs(): Response<ApiResponse<List<FaqDto>>>

    // --- AUTH API ---

    @POST("login")
    suspend fun login(@Body request: LoginRequest): Response<LoginResponse>

    @POST("logout")
    suspend fun logout(): Response<ApiResponse<Unit>>

    @GET("me")
    suspend fun getMe(): Response<AdminDto>

    // --- ADMIN API ---

    // Portfolios
    @GET("admin/portfolios")
    suspend fun getAdminPortfolios(@Query("page") page: Int? = null): Response<ApiResponse<PaginatedData<PortfolioDto>>>

    @Multipart
    @POST("admin/portfolios")
    suspend fun createPortfolio(
        @Part("title") title: RequestBody,
        @Part("category") category: RequestBody,
        @Part("description") description: RequestBody?,
        @Part image: MultipartBody.Part?,
        @Part("is_published") isPublished: RequestBody?,
        @Part("sort_order") sortOrder: RequestBody?
    ): Response<ApiResponse<PortfolioDetailDto>>

    @GET("admin/portfolios/{id}")
    suspend fun getAdminPortfolioDetail(@Path("id") id: Int): Response<ApiResponse<PortfolioDetailDto>>

    @Multipart
    @PUT("admin/portfolios/{id}")
    suspend fun updatePortfolio(
        @Path("id") id: Int,
        @Part("title") title: RequestBody?,
        @Part("category") category: RequestBody?,
        @Part("description") description: RequestBody?,
        @Part image: MultipartBody.Part?,
        @Part("_method") method: RequestBody = RequestBody.create(MultipartBody.FORM, "PUT"),
        @Part("is_published") isPublished: RequestBody?,
        @Part("sort_order") sortOrder: RequestBody?
    ): Response<ApiResponse<PortfolioDetailDto>>

    @DELETE("admin/portfolios/{id}")
    suspend fun deletePortfolio(@Path("id") id: Int): Response<ApiResponse<Unit>>

    // Portfolio Phases
    @GET("admin/portfolios/{id}/phases")
    suspend fun getPortfolioPhases(@Path("id") portfolioId: Int): Response<ApiResponse<List<PortfolioPhaseDto>>>

    @FormUrlEncoded
    @PUT("admin/portfolios/{portfolioId}/phases/{phaseId}")
    suspend fun updatePortfolioPhase(
        @Path("portfolioId") portfolioId: Int,
        @Path("phaseId") phaseId: Int,
        @Field("title") title: String,
        @Field("description") description: String?
    ): Response<ApiResponse<PortfolioPhaseDto>>

    @Multipart
    @POST("admin/portfolios/{portfolio}/phases/{phase}/images")
    suspend fun uploadPhaseImages(
        @Path("portfolio") portfolioId: Int,
        @Path("phase") phaseId: Int,
        @Part images: List<MultipartBody.Part>
    ): Response<ApiResponse<PortfolioDetailDto>>

    @DELETE("admin/portfolios/{portfolio}/phases/{phase}/images/{image}")
    suspend fun deletePhaseImage(
        @Path("portfolio") portfolioId: Int,
        @Path("phase") phaseId: Int,
        @Path("image") imageId: Int
    ): Response<ApiResponse<Unit>>

    // Hero Slides
    @GET("admin/hero-slides")
    suspend fun getAdminHeroSlides(): Response<ApiResponse<List<HeroSlideDto>>>

    @Multipart
    @POST("admin/hero-slides")
    suspend fun createHeroSlides(@Part images: List<MultipartBody.Part>): Response<ApiResponse<List<HeroSlideDto>>>

    @DELETE("admin/hero-slides/{id}")
    suspend fun deleteHeroSlide(@Path("id") id: Int): Response<ApiResponse<Unit>>

    @POST("admin/hero-slides/reorder")
    suspend fun reorder(@Body body: Map<String, List<Int>>): Response<ApiResponse<Unit>>

    // Services
    @GET("admin/services")
    suspend fun getAdminServices(): Response<ApiResponse<List<ServiceDto>>>

    @Multipart
    @POST("admin/services")
    suspend fun createService(
        @Part("title") title: RequestBody,
        @Part("description") description: RequestBody,
        @Part image: MultipartBody.Part?,
        @Part("status") status: RequestBody?,
        @Part("sort_order") sortOrder: RequestBody?
    ): Response<ApiResponse<ServiceDto>>

    @GET("admin/services/{id}")
    suspend fun getAdminServiceDetail(@Path("id") id: Int): Response<ApiResponse<ServiceDto>>

    @Multipart
    @POST("admin/services/{id}")
    suspend fun updateService(
        @Path("id") id: Int,
        @Part("title") title: RequestBody,
        @Part("description") description: RequestBody,
        @Part image: MultipartBody.Part?,
        @Part("status") status: RequestBody?,
        @Part("sort_order") sortOrder: RequestBody?,
        @Part("_method") method: RequestBody = RequestBody.create(MultipartBody.FORM, "PUT")
    ): Response<ApiResponse<ServiceDto>>

    @DELETE("admin/services/{id}")
    suspend fun deleteService(@Path("id") id: Int): Response<ApiResponse<Unit>>

    // Team Profiles
    @GET("admin/team-profiles")
    suspend fun getAdminTeamProfiles(): Response<ApiResponse<List<TeamProfileDto>>>

    @Multipart
    @POST("admin/team-profiles")
    suspend fun createTeamProfile(
        @Part("name") name: RequestBody,
        @Part("position") position: RequestBody?,
        @Part("instagram") instagram: RequestBody?,
        @Part("linkedin") linkedin: RequestBody?,
        @Part("image_path") image: MultipartBody.Part?,
        @Part("is_published") isPublished: RequestBody?,
        @Part("sort_order") sortOrder: RequestBody?
    ): Response<ApiResponse<TeamProfileDto>>

    @GET("admin/team-profiles/{id}")
    suspend fun getAdminTeamProfileDetail(@Path("id") id: Int): Response<ApiResponse<TeamProfileDto>>

    @Multipart
    @POST("admin/team-profiles/{id}")
    suspend fun updateTeamProfile(
        @Path("id") id: Int,
        @Part("name") name: RequestBody?,
        @Part("position") position: RequestBody?,
        @Part("instagram") instagram: RequestBody?,
        @Part("linkedin") linkedin: RequestBody?,
        @Part("image_path") image: MultipartBody.Part?,
        @Part("_method") method: RequestBody = RequestBody.create(MultipartBody.FORM, "PUT"),
        @Part("is_published") isPublished: RequestBody?,
        @Part("sort_order") sortOrder: RequestBody?
    ): Response<ApiResponse<TeamProfileDto>>

    @DELETE("admin/team-profiles/{id}")
    suspend fun deleteTeamProfile(@Path("id") id: Int): Response<ApiResponse<Unit>>

    // Projects
    @GET("admin/projects")
    suspend fun getAdminProjects(@Query("page") page: Int? = null): Response<ApiResponse<PaginatedData<ProjectDto>>>

    @Multipart
    @POST("admin/projects")
    suspend fun createProject(
        @Part("name") name: RequestBody,
        @Part("client") client: RequestBody,
        @Part("location") location: RequestBody?,
        @Part("category") category: RequestBody?,
        @Part("start_date") startDate: RequestBody?,
        @Part("deadline") deadline: RequestBody?,
        @Part("status") status: RequestBody?,
        @Part("progress") progress: RequestBody?,
        @Part("description") description: RequestBody?,
        @Part cover_image: MultipartBody.Part?
    ): Response<ApiResponse<ProjectDto>>

    @GET("admin/projects/{id}")
    suspend fun getAdminProjectDetail(@Path("id") id: Int): Response<ApiResponse<ProjectDto>>

    @Multipart
    @POST("admin/projects/{id}")
    suspend fun updateProject(
        @Path("id") id: Int,
        @Part("name") name: RequestBody?,
        @Part("client") client: RequestBody?,
        @Part("location") location: RequestBody?,
        @Part("category") category: RequestBody?,
        @Part("start_date") startDate: RequestBody?,
        @Part("deadline") deadline: RequestBody?,
        @Part("status") status: RequestBody?,
        @Part("progress") progress: RequestBody?,
        @Part("description") description: RequestBody?,
        @Part cover_image: MultipartBody.Part?,
        @Part("_method") method: RequestBody = RequestBody.create(MultipartBody.FORM, "PUT")
    ): Response<ApiResponse<ProjectDto>>

    @DELETE("admin/projects/{id}")
    suspend fun deleteProject(@Path("id") id: Int): Response<ApiResponse<Unit>>

    // Project Stages
    @GET("admin/projects/{project}/stages")
    suspend fun getProjectStages(@Path("project") projectId: Int): Response<ApiResponse<List<ProjectStageDto>>>

    @POST("admin/projects/{project}/stages")
    suspend fun createProjectStage(
        @Path("project") projectId: Int,
        @Body request: Map<String, String> // Simplified for now, or create a DTO
    ): Response<ApiResponse<ProjectStageDto>>

    @GET("admin/projects/{project}/stages/{stage}")
    suspend fun getProjectStageDetail(
        @Path("project") projectId: Int,
        @Path("stage") stageId: Int
    ): Response<ApiResponse<ProjectStageDto>>

    @PUT("admin/projects/{project}/stages/{stage}")
    suspend fun updateProjectStage(
        @Path("project") projectId: Int,
        @Path("stage") stageId: Int,
        @Body request: Map<String, String>
    ): Response<ApiResponse<ProjectStageDto>>

    @DELETE("admin/projects/{project}/stages/{stage}")
    suspend fun deleteProjectStage(
        @Path("project") projectId: Int,
        @Path("stage") stageId: Int
    ): Response<ApiResponse<Unit>>

    // Settings
    @GET("admin/settings")
    suspend fun getAdminSettings(): Response<ApiResponse<SettingDto>>

    @Multipart
    @PUT("admin/settings")
    suspend fun updateSettings(
        @PartMap data: Map<String, @JvmSuppressWildcards RequestBody>,
        @Part images: List<MultipartBody.Part>,
        @Part("_method") method: RequestBody = RequestBody.create(MultipartBody.FORM, "PUT")
    ): Response<ApiResponse<SettingDto>>
}

data class InitDataResponse(
    val settings: SettingDto,
    val hero_slides: List<HeroSlideDto>,
    val affiliated_divisions: List<AffiliatedDivisionDto>
)
