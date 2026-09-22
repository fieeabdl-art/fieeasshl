package com.example.bumiyuji.ui.screens

import android.net.Uri
import androidx.activity.compose.rememberLauncherForActivityResult
import androidx.activity.result.contract.ActivityResultContracts
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.CloudUpload
import androidx.compose.material.icons.filled.Info
import androidx.compose.material.icons.filled.Mail
import androidx.compose.material.icons.filled.Phone
import androidx.compose.material.icons.filled.Web
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.graphics.vector.ImageVector
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import coil.compose.AsyncImage
import com.example.bumiyuji.ui.UiState
import com.example.bumiyuji.ui.components.BumiyujiButton
import com.example.bumiyuji.ui.components.BumiyujiLoading
import com.example.bumiyuji.ui.components.BumiyujiTextField
import com.example.bumiyuji.ui.components.BumiyujiTopBar
import com.example.bumiyuji.ui.theme.DarkCharcoal
import com.example.bumiyuji.ui.theme.GoldAccent
import com.example.bumiyuji.ui.theme.WarmCream
import com.example.bumiyuji.ui.viewmodel.SettingViewModel
import com.example.bumiyuji.util.FileUtils
import com.example.bumiyuji.util.ImageUtils
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody
import okhttp3.RequestBody.Companion.asRequestBody

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun SettingScreen(
    viewModel: SettingViewModel,
    onBackClick: () -> Unit
) {
    val context = LocalContext.current
    LaunchedEffect(Unit) {
        viewModel.fetchSettings()
    }

    val uiState = viewModel.uiState
    var siteName by remember { mutableStateOf("") }
    var heroTitle by remember { mutableStateOf("") }
    var heroSubtitle by remember { mutableStateOf("") }
    var contactEmail by remember { mutableStateOf("") }
    var contactWhatsapp by remember { mutableStateOf("") }

    // Image Uris
    var logoUri by remember { mutableStateOf<Uri?>(null) }
    var faviconUri by remember { mutableStateOf<Uri?>(null) }
    var heroImageUri by remember { mutableStateOf<Uri?>(null) }
    var aboutImageUri by remember { mutableStateOf<Uri?>(null) }

    // Remote URLs
    var remoteLogoUrl by remember { mutableStateOf<String?>(null) }
    var remoteFaviconUrl by remember { mutableStateOf<String?>(null) }
    var remoteHeroImageUrl by remember { mutableStateOf<String?>(null) }
    var remoteAboutImageUrl by remember { mutableStateOf<String?>(null) }

    val logoLauncher = rememberLauncherForActivityResult(ActivityResultContracts.GetContent()) { logoUri = it }
    val faviconLauncher = rememberLauncherForActivityResult(ActivityResultContracts.GetContent()) { faviconUri = it }
    val heroLauncher = rememberLauncherForActivityResult(ActivityResultContracts.GetContent()) { heroImageUri = it }
    val aboutLauncher = rememberLauncherForActivityResult(ActivityResultContracts.GetContent()) { aboutImageUri = it }

    LaunchedEffect(uiState) {
        if (uiState is UiState.Success) {
            siteName = uiState.data.site_name ?: ""
            heroTitle = uiState.data.hero?.title ?: ""
            heroSubtitle = uiState.data.hero?.subtitle ?: ""
            contactEmail = uiState.data.contact?.email ?: ""
            contactWhatsapp = uiState.data.contact?.whatsapp ?: ""

            remoteLogoUrl = uiState.data.logo_url
            remoteFaviconUrl = uiState.data.favicon_url
            remoteHeroImageUrl = uiState.data.hero?.image_url
            remoteAboutImageUrl = uiState.data.about?.image_url
        }
    }

    Scaffold(
        topBar = {
            BumiyujiTopBar(title = "Pengaturan", onBackClick = onBackClick)
        },
        containerColor = WarmCream
    ) { innerPadding ->
        Box(modifier = Modifier.padding(innerPadding).fillMaxSize()) {
            when (uiState) {
                is UiState.Loading -> BumiyujiLoading()
                is UiState.Error -> {
                    Column(modifier = Modifier.align(Alignment.Center), horizontalAlignment = Alignment.CenterHorizontally) {
                        Text(text = uiState.message, color = MaterialTheme.colorScheme.error)
                        Button(onClick = { viewModel.fetchSettings() }) { Text("Coba Lagi") }
                    }
                }
                is UiState.Success, is UiState.Idle -> {
                    Column(
                        modifier = Modifier
                            .fillMaxSize()
                            .padding(20.dp)
                            .verticalScroll(rememberScrollState()),
                        verticalArrangement = Arrangement.spacedBy(24.dp)
                    ) {
                        SettingSection(title = "Identitas Website", icon = Icons.Default.Web) {
                            BumiyujiTextField(
                                value = siteName,
                                onValueChange = { siteName = it },
                                label = "Nama Website"
                            )
                            Spacer(modifier = Modifier.height(16.dp))

                            Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                                ImagePickerField(
                                    label = "Logo",
                                    selectedUri = logoUri,
                                    remoteUrl = remoteLogoUrl,
                                    modifier = Modifier.weight(1f),
                                    onClick = { logoLauncher.launch("image/*") }
                                )
                                ImagePickerField(
                                    label = "Favicon",
                                    selectedUri = faviconUri,
                                    remoteUrl = remoteFaviconUrl,
                                    modifier = Modifier.weight(1f),
                                    onClick = { faviconLauncher.launch("image/*") }
                                )
                            }
                        }

                        SettingSection(title = "Banner Hero", icon = Icons.Default.Info) {
                            BumiyujiTextField(
                                value = heroTitle,
                                onValueChange = { heroTitle = it },
                                label = "Judul Utama"
                            )
                            Spacer(modifier = Modifier.height(12.dp))
                            BumiyujiTextField(
                                value = heroSubtitle,
                                onValueChange = { heroSubtitle = it },
                                label = "Sub-judul",
                                singleLine = false
                            )
                            Spacer(modifier = Modifier.height(16.dp))
                            ImagePickerField(
                                label = "Background Hero",
                                selectedUri = heroImageUri,
                                remoteUrl = remoteHeroImageUrl,
                                onClick = { heroLauncher.launch("image/*") }
                            )
                        }

                        SettingSection(title = "Tentang Kami", icon = Icons.Default.Info) {
                            ImagePickerField(
                                label = "Gambar Section About",
                                selectedUri = aboutImageUri,
                                remoteUrl = remoteAboutImageUrl,
                                onClick = { aboutLauncher.launch("image/*") }
                            )
                        }

                        SettingSection(title = "Kontak", icon = Icons.Default.Mail) {
                            BumiyujiTextField(
                                value = contactEmail,
                                onValueChange = { contactEmail = it },
                                label = "Email Perusahaan"
                            )
                            Spacer(modifier = Modifier.height(12.dp))
                            BumiyujiTextField(
                                value = contactWhatsapp,
                                onValueChange = { contactWhatsapp = it },
                                label = "Nomor WhatsApp"
                            )
                        }

                        Spacer(modifier = Modifier.height(8.dp))

                        BumiyujiButton(
                            text = "Simpan Perubahan",
                            onClick = {
                                val data = mutableMapOf<String, RequestBody>()
                                data["site_name"] = RequestBody.create(MultipartBody.FORM, siteName)
                                data["hero_title"] = RequestBody.create(MultipartBody.FORM, heroTitle)
                                data["hero_subtitle"] = RequestBody.create(MultipartBody.FORM, heroSubtitle)
                                data["contact_email"] = RequestBody.create(MultipartBody.FORM, contactEmail)
                                data["contact_whatsapp"] = RequestBody.create(MultipartBody.FORM, contactWhatsapp)

                                val images = mutableListOf<MultipartBody.Part>()
                                logoUri?.let { uri ->
                                    val file = FileUtils.uriToFile(uri, context)
                                    val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                                    images.add(MultipartBody.Part.createFormData("logo", file.name, requestFile))
                                }
                                faviconUri?.let { uri ->
                                    val file = FileUtils.uriToFile(uri, context)
                                    val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                                    images.add(MultipartBody.Part.createFormData("favicon", file.name, requestFile))
                                }
                                heroImageUri?.let { uri ->
                                    val file = FileUtils.uriToFile(uri, context)
                                    val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                                    images.add(MultipartBody.Part.createFormData("hero_image", file.name, requestFile))
                                }
                                aboutImageUri?.let { uri ->
                                    val file = FileUtils.uriToFile(uri, context)
                                    val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                                    images.add(MultipartBody.Part.createFormData("about_image", file.name, requestFile))
                                }

                                viewModel.updateSettings(data, images)
                            },
                            isLoading = uiState is UiState.Loading
                        )
                    }
                }
            }
        }
    }
}

@Composable
fun ImagePickerField(
    label: String,
    selectedUri: Uri?,
    remoteUrl: String?,
    modifier: Modifier = Modifier,
    onClick: () -> Unit
) {
    Column(modifier = modifier) {
        Text(text = label, style = MaterialTheme.typography.labelMedium, color = Color.Gray)
        Spacer(modifier = Modifier.height(8.dp))
        Box(
            modifier = Modifier
                .fillMaxWidth()
                .height(100.dp)
                .clip(RoundedCornerShape(12.dp))
                .background(Color.White)
                .border(1.dp, Color.Gray.copy(alpha = 0.2f), RoundedCornerShape(12.dp))
                .clickable { onClick() },
            contentAlignment = Alignment.Center
        ) {
            if (selectedUri != null) {
                AsyncImage(
                    model = selectedUri,
                    contentDescription = null,
                    modifier = Modifier.fillMaxSize(),
                    contentScale = ContentScale.Crop
                )
            } else if (remoteUrl != null) {
                AsyncImage(
                    model = ImageUtils.resolveImageUrl(remoteUrl),
                    contentDescription = null,
                    modifier = Modifier.fillMaxSize(),
                    contentScale = ContentScale.Crop
                )
            } else {
                Icon(Icons.Default.CloudUpload, contentDescription = null, tint = GoldAccent.copy(alpha = 0.5f))
            }
        }
    }
}

@Composable
fun SettingSection(
    title: String,
    icon: ImageVector,
    content: @Composable ColumnScope.() -> Unit
) {
    Column {
        Row(verticalAlignment = Alignment.CenterVertically) {
            Icon(imageVector = icon, contentDescription = null, tint = GoldAccent, modifier = Modifier.size(20.dp))
            Spacer(modifier = Modifier.width(8.dp))
            Text(text = title, style = MaterialTheme.typography.titleMedium, fontWeight = FontWeight.Bold, color = DarkCharcoal)
        }
        Spacer(modifier = Modifier.height(12.dp))
        Surface(
            modifier = Modifier.fillMaxWidth(),
            shape = RoundedCornerShape(16.dp),
            color = Color.White,
            shadowElevation = 1.dp
        ) {
            Column(modifier = Modifier.padding(16.dp)) {
                content()
            }
        }
    }
}
