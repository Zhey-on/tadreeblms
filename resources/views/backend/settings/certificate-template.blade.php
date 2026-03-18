@extends('backend.layouts.app')
@section('title', 'Certificate Template | ' . app_name())

@push('after-styles')
<style>
    .certificate-card {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    .certificate-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .certificate-preview {
        position: relative;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        padding: 40px 50px;
        min-height: 420px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        font-family: 'Georgia', serif;
    }

    .certificate-preview .border-ornament {
        position: absolute;
        inset: 12px;
        border: 2px solid rgba(212, 175, 55, 0.5);
        border-radius: 6px;
        pointer-events: none;
    }

    .certificate-preview .border-ornament::before,
    .certificate-preview .border-ornament::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border-color: #d4af37;
        border-style: solid;
    }

    .certificate-preview .border-ornament::before {
        top: -2px;
        left: -2px;
        border-width: 3px 0 0 3px;
    }

    .certificate-preview .border-ornament::after {
        bottom: -2px;
        right: -2px;
        border-width: 0 3px 3px 0;
    }

    .cert-badge {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #d4af37, #f5d670);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.4);
    }

    .cert-badge i {
        font-size: 32px;
        color: #1a1a2e;
    }

    .cert-label {
        font-size: 11px;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: #d4af37;
        margin-bottom: 6px;
    }

    .cert-title {
        font-size: 28px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #ffffff;
        margin-bottom: 12px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .cert-divider {
        width: 80px;
        height: 2px;
        background: linear-gradient(to right, transparent, #d4af37, transparent);
        margin: 12px auto;
    }

    .cert-presented-to {
        font-size: 13px;
        color: rgba(255,255,255,0.7);
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .cert-recipient-name {
        font-size: 26px;
        font-style: italic;
        color: #f5d670;
        margin-bottom: 10px;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    }

    .cert-course-label {
        font-size: 11px;
        color: rgba(255,255,255,0.6);
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .cert-course-name {
        font-size: 16px;
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .cert-footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        width: 100%;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid rgba(212, 175, 55, 0.3);
    }

    .cert-signature-block {
        text-align: center;
        flex: 1;
    }

    .cert-signature-line {
        width: 100px;
        height: 1px;
        background: rgba(212, 175, 55, 0.6);
        margin: 0 auto 6px;
    }

    .cert-signature-label {
        font-size: 9px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.5);
    }

    .cert-seal {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #d4af37, #f5d670);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.2), 0 0 0 8px rgba(212, 175, 55, 0.1);
        flex-shrink: 0;
        margin: 0 20px;
    }

    .cert-seal i {
        font-size: 24px;
        color: #1a1a2e;
    }

    .template-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: rgba(212, 175, 55, 0.15);
        border: 1px solid rgba(212, 175, 55, 0.4);
        color: #d4af37;
        font-size: 10px;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .page-header-section {
        background: #fff;
        border-radius: 10px;
        padding: 24px 28px;
        margin-bottom: 24px;
        border: 1px solid #e8e8e8;
    }

    .page-header-section h4 {
        margin-bottom: 4px;
        font-size: 20px;
        font-weight: 600;
        color: #2c3e50;
    }

    .page-header-section p {
        margin: 0;
        color: #7f8c8d;
        font-size: 14px;
    }

    .template-info-row {
        display: flex;
        gap: 12px;
        margin-top: 16px;
        flex-wrap: wrap;
    }

    .template-info-pill {
        background: #f4f6f9;
        border: 1px solid #e0e0e0;
        border-radius: 20px;
        padding: 4px 14px;
        font-size: 12px;
        color: #555;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .template-info-pill i {
        color: #3d85c8;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    <div class="page-header-section">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h4><i class="fas fa-certificate mr-2 text-warning"></i>Certificate Template</h4>
                <p>Preview and manage certificate templates issued to learners upon course completion.</p>
            </div>
        </div>
        <div class="template-info-row">
            <span class="template-info-pill"><i class="fas fa-palette"></i> 1 Template Available</span>
            <span class="template-info-pill"><i class="fas fa-check-circle"></i> Sample Preview</span>
            <span class="template-info-pill"><i class="fas fa-expand-arrows-alt"></i> A4 Landscape</span>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-10 col-md-12">
            <div class="card certificate-card">
                <div class="card-header d-flex align-items-center justify-content-between bg-white">
                    <div class="d-flex align-items-center">
                        <span class="badge badge-warning mr-2" style="font-size:11px;">Default</span>
                        <strong style="font-size:15px;">Classic Dark Template</strong>
                    </div>
                    <small class="text-muted">Sample Preview</small>
                </div>

                <div class="certificate-preview">
                    <div class="border-ornament"></div>
                    <span class="template-badge">Sample Template</span>

                    <div class="cert-badge">
                        <i class="fas fa-award"></i>
                    </div>

                    <div class="cert-label">Certificate of Completion</div>
                    <div class="cert-title">Achievement Award</div>
                    <div class="cert-divider"></div>

                    <div class="cert-presented-to">This certificate is proudly presented to</div>
                    <div class="cert-recipient-name">John A. Smith</div>

                    <div class="cert-course-label">for successfully completing</div>
                    <div class="cert-course-name">Advanced Web Development Fundamentals</div>

                    <div class="cert-footer">
                        <div class="cert-signature-block">
                            <div class="cert-signature-line"></div>
                            <div class="cert-signature-label">Instructor</div>
                        </div>

                        <div class="cert-seal">
                            <i class="fas fa-star"></i>
                        </div>

                        <div class="cert-signature-block">
                            <div class="cert-signature-line"></div>
                            <div class="cert-signature-label">Date Issued</div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white d-flex align-items-center justify-content-between">
                    <div class="text-muted" style="font-size:13px;">
                        <i class="fas fa-info-circle mr-1"></i>
                        This is a preview of the certificate template. Actual certificates include the learner's name, course details, and completion date.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-2 col-md-12 mt-3 mt-lg-0">
            <div class="card h-auto">
                <div class="card-header bg-white">
                    <strong>Template Details</strong>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0" style="font-size:14px; line-height: 2;">
                        <li><i class="fas fa-tag text-warning mr-2"></i><strong>Name:</strong> Classic Dark</li>
                        <li><i class="fas fa-ruler-combined text-warning mr-2"></i><strong>Format:</strong> A4 Landscape</li>
                        <li><i class="fas fa-palette text-warning mr-2"></i><strong>Theme:</strong> Dark Gold</li>
                        <li><i class="fas fa-font text-warning mr-2"></i><strong>Font:</strong> Georgia (Serif)</li>
                        <li><i class="fas fa-check-circle text-success mr-2"></i><strong>Status:</strong> Active</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
